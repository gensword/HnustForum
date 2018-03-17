<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('article')->insert([
            'article_status_id' => 1,
            'article_category_id' => 2,
            'user_id' => 1,
            'title' => '你必须知道的 17 个 Composer 最佳实践（已更新至 22 个）',
            'content' => '尽管大多数 PHP 开发人员都知道如何使用 Composer ，但并不是所有的人都在有效地或以最好的方式使用它。 所以我决定总结一些对我日常工作流程很重要的东西。

大部分技巧的理念是「 Play it safe 」，这意味着如果有更多的方法来处理某些事情，我会使用最不容易出错的方法。

 阿文 翻译于 3周前
  
 查看其他 1 个版本
Tip #1: 阅读文档
我是认真的。 官方的文档 写得非常棒，现在只需几个小时的阅读，会给你未来节省很多时间。你会惊讶于 Composer 如此之多能。

Tip #2: 认识 "项目" 和 "库" 间的不同
创建的是“项目”还是“库”，意识到这点非常重要。这两者在使用过程中，都存在非常巨大的差异。

库是一个可重用的包，需要作为一个依赖项进行添加 - 比如  symfony/symfony, doctrine/orm 或 elasticsearch/elasticsearch.

而典型的项目是一个应用程序，要依赖于多个库。它通常不可重用（其他项目不需要它成为一个依赖项）。像电子商务网站、客户服务系统等类型的应用就是典型的例子。

在下面的 Tip 中，我会更仔细地讲解库和项目两者的区别。

 bigqiang 翻译于 3周前
  
 查看其他 1 个版本
Tip #3: 为应用程序使用指定的依赖版本
创建应用程序时，应使用最清晰的版本号定义依赖项。 如果需要解析 YAML 文件，就应该以 "symfony/yaml": "4.0.2" 这样的形式明确依赖项。

即使依赖的库遵循了 语义化版本 规范，也会因次版本号和修订号的不同破坏后向兼容性。 例如，使用形如 "symfony/symfony": "^3.1"，有可能存在在 3.2 版本废弃的东西，而这会破坏你的应用程序在该版本下通过测试。或者可能在 PHP_CodeSniffer 中存在一个已修复的 bug ，代码就会检测出新的格式问题，这会再次导致错误的构建。

依赖的升级要慎之又慎，不能撞大运。下面 Tip 当中会有一条对此进行更详细的讲解。

听起来有些危言耸听，但是注意这个要点就会避免你的合作伙伴向项目中在添加新库时不小心更新了所有依赖（代码审查时可能忽略这一点）。

 bigqiang 翻译于 3周前
  
 查看其他 1 个版本
Tip #4: 对库依赖项使用版本范围
创建库时，应尽可能定义最大的可用版本范围。比如创建了一个库，要使用 symfony/yaml 库进行 YAML 解析，就应这样写：',
            'votes_total' => 0,
            'comments_total' => 0,
            'read_total' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }
}
