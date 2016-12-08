<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Ajax extends Controller{

	public function action_sort()
    {
        if (Request::initial()->is_ajax())
        {
            //page
            if (isset($_POST['sortPage'])){

                $array	= $_POST['array_order'];
                $count = 1;

                foreach ($array as $idval) {

                    $data = array('sort' =>  $count);

                    ORM::factory('Page',$idval)
                        ->values($data)
                        ->save();

                    $count ++;
                }

                echo '<div class="alert alert-success"><p>Положение страницы сохранено!</p></div>';
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_hideShow()
    {
        if (Request::initial()->is_ajax())
        {
            if (isset($_POST['hideShowPage'])){

                $id	= $_POST['id'];

                $page = ORM::factory('Page')->where('id','=',$id)->find();

                if($page->view == 1){
                    ORM::factory('Page',$id)
                        ->set('view',0)
                        ->save();

                    echo '<i class="fa fa-eye-slash"></i>';
                }else{
                    ORM::factory('Page',$id)
                        ->set('view',1)
                        ->save();

                    echo '<i class="fa fa-eye"></i>';
                }
            }
            if (isset($_POST['hideShowNews'])){

                $id	= $_POST['id'];

                $news = ORM::factory('News_Items')->where('id','=',$id)->find();

                if($news->view == 1){
                    ORM::factory('News_Items',$id)
                        ->set('view',0)
                        ->save();

                    echo '<i class="fa fa-eye-slash"></i>';
                }else{
                    ORM::factory('News_Items',$id)
                        ->set('view',1)
                        ->save();

                    echo '<i class="fa fa-eye"></i>';
                }
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_delete()
    {
        if (Request::initial()->is_ajax())
        {
            if (isset($_POST['deletePage'])){

                 ORM::factory('Page',$_POST['id'])->soft_delete();

                echo '<div class="alert alert-success"><p>'.Kohana::message('success', 'admin.page.delete_soft').'</p></div>';

            }

            if (isset($_POST['deleteNews'])){

                ORM::factory('News_Items',$_POST['id'])->soft_delete();

                echo '<div class="alert alert-success"><p>'.Kohana::message('success', 'admin.news.delete_soft').'</p></div>';

            }
        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_change()
    {
        if (Request::initial()->is_ajax()) {
            if (isset($_POST['changeLangPage'])){

                $list = '<option>'.__('Нет').'</option>';

                $list .= ORM::factory('Page')->get_page_option([],$_POST['lang']);

                echo $list;
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////

}
?>