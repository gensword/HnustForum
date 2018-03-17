<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\NewsController;
use App\Husers;
use App\Notify;
use App\Events\SendMsg;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Qiniu\Auth;

class UserController extends Controller
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
        return Admin::grid(Husers::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->username('username');
            $grid->created_at();
            $grid->updated_at();

            $grid->filter(function($filter){

                // 去掉默认的id过滤器
                $filter->disableIdFilter();

                // 在这里添加字段过滤器
                $filter->like('username', 'username');

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
        return Admin::form(Husers::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('username', 'username');
            $form->select('user_status_id', 'user status')->options([0 => 'forbidden user' ,1 => 'normal user', 2 => 'admin', 3 => 'founder']);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            $form->saved(function (Form $form) {
                    switch($form->user_status_id){
                        case 1:
                            $content = '您的账号已被 处理为普通用户,'.'若有疑问请联系xzy';
                            break;
                        case 2:
                            $content = '您的账号已被处理为管理员,'.'若有疑问请联系xzy';
                            break;
                        case 3:
                            $content = '您的账号已被处理为开发者,'.'若有疑问请联系xzy';
                            break;
                        default:break;
                    }
                    if($content){
                    $message = array('content' => $content, 'to_uid' =>  $form->model()->id);
                    $channel = 'notification';
                    event(new sendMsg($message, $channel));

                    $notification = New Notify;
                    $notification->from_uid = 1;
                    $notification->to_uid =  $form->model()->id;;
                    $notification->content = $content;
                    $notification->save();}

            });
        });
    }
}
