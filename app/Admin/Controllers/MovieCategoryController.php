<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\CheckRow;
use App\Category;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class MovieCategoryController extends Controller
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
        return Admin::grid(Category::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->icon('图标 ')->display(function ($icon) {
                return "<img class='img-md img-circle' src=\"$icon\" alt=\"\" >";
            });;
            $grid->created_at();
            $grid->updated_at();
            $grid->actions(function ($actions){

//
//                $actions->disableDelete();
//                $actions->disableEdit();
//                // 当前行的数据数组
//                $actions->row;
//
//                // 获取当前行主键值
//                $actions->getKey();

                // append一个操作
                $actions->append('<a href=""><i class="fa fa-eye"></i></a>');

                // prepend一个操作
                $actions->prepend('<a href=""><i class="fa fa-paper-plane"></i></a>');


                $actions->append(new CheckRow($actions->getKey()));

            });






//            $states = [
//                'on' => ['text' => 'YES'],
//                'off' => ['text' => 'NO'],
//            ];
//
//            $grid->column('switch_group')->switchGroup([
//                'hot'=> '热门',
//                'new' => '最新',
//                 'recommend' => '推荐',
//                ], $states);
            $grid->column('status', '状态')->select([
                1 => '有效',
                0 => '禁用',
            ])->display(function ($r) {
                if ($this->status) {
                    return $r . "<span class='label  label-success'> 有效</span>" ;
                }else{
                    return $r . "<span class='label  label-danger'> 禁用</span>";

                }

            });

//            $grid->column('statusd', '状态')->display(function () use ($grid) {
//                if ($this->status) {
//                    return "<span class='label  label-success'> 有效</span>";
//                }else{
//                    return "<span class='label-danger'> 禁用</span>";
//
//                }
//
//            });



////设置颜色，默认`success`,可选`danger`、`warning`、`info`、`primary`、`default`、`success`
//            $grid->name()->label('info');
//
//
//
////设置颜色，默认`success`,可选`danger`、`warning`、`info`、`primary`、`default`、`success`
//            $grid->status()->badge('danger');

        });




    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $category = null;

        return Admin::form(Category::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name');
//            $form->image('icon ');
            $form->image('icon')->uniqueName();
            $form->select('status')->options([1 => '启用', 0 => '禁用'])->default(0); //状态：0禁用，1启用
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
            $form->select('select')->options('http://www.baidu.com');

            //            $form->checkbox('checkbox')->options([1 => 'foo', 2 => 'bar', 'val' => 'Option name']);
//            $form->radio('radio')->options(['m' => 'Female', 'f'=> 'Male'])->stacked();
//            $form->listbox('2')->options([1 => 'foo', 2 => 'bar', 33 => 'Option name']);
            $form->number('ss')->max(100);
//            $form->map('2', '22', '地图');
            $form->tools(function (Form\Tools $tools) {

//                // 去掉返回按钮
//                $tools->disableBackButton();
//
//                // 去掉跳转列表按钮
//                $tools->disableListButton();
//
//                // 添加一个按钮, 参数可以是字符串, 或者实现了Renderable或Htmlable接口的对象实例
//                $tools->add('<a class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;delete</a>');
            });
        });
    }
}

