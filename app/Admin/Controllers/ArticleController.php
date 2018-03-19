<?php

namespace App\Admin\Controllers;

use App\Article;
use App\Events\SendMsg;
use App\Notify;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ArticleController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Article::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('title');
            $grid->created_at();
            $grid->updated_at();

            $grid->filter(function($filter){

                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器
                $filter->like('title', 'title');

            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Article::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('title', 'Title');
            $form->display('content', 'Content');
            $form->select('article_status_id', 'Article status')->options([0 => 'sink' ,1 => 'normal ', 2 => 'stick', 4 => 'digest', 6 => 'stick and digest']);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saved(function (Form $form) {
                switch($form->article_status_id){
                    case 0:
                        $content = '你的文章 '.$form->model()->title.' 被下沉';
                        break;
                    case 2:
                        $content = '你的文章 '.$form->model()->title.' 被置顶';
                        break;
                    case 4:
                        $content = '你的文章 '.$form->model()->title.' 被加精';
                        break;
                    case 6:
                        $content = '你的文章 '.$form->model()->title.' 被加精置顶';
                        break;
                    default:break;
                }
                if($content){
                    $message = array('content' => $content, 'to_uid' =>  $form->model()->user->id);
                    $channel = 'notification';
                    event(new sendMsg($message, $channel));

                    $notification = New Notify;
                    $notification->from_uid = 1;
                    $notification->to_uid =  $form->model()->user->id;
                    $notification->content = $content;
                    $notification->save();}

            });
        });
    }
}
