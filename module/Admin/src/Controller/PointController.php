<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
* @desc 账户管理
*/
class PointController extends AbstractActionController
{
    //go to index page
    public function indexAction()
    {
        return new ViewModel([
            'workyard_id' => $this->params()->fromQuery('workyard_id'),
            'where' => $this->params()->fromQuery(),
            'page'  => $this->params()->fromQuery('page', 1),
        ]);
    }
    
    //goto add page
//     public function addPageAction()
//     {
//         return new ViewModel($this->params()->fromRoute());
//     }
    
//     //goto edit page
//     public function editPageAction()
//     {
//         return new ViewModel($this->params()->fromRoute());
//     }
    
    //goto add page
    public function addModalAction()
    {
        $this->layout()->setTemplate('layout/blank.phtml');
        return new ViewModel([
        ]);
    }
    
    //goto edit page
    public function editModalAction()
    {
        $this->layout()->setTemplate('layout/blank.phtml');
        return new ViewModel($this->params()->fromRoute());
    }
    
    //goto delete page
    public function deleteModalAction()
    {
        $this->layout()->setTemplate('layout/blank.phtml');
        return new ViewModel($this->params()->fromRoute());
    }
}
