<?php
namespace Api\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Api\Service\ShiftManager;
use Api\Entity\ShiftEntity;
use Api\Service\ShiftGuardManager;
use Api\Entity\ShiftGuardEntity;
use Api\Service\ShiftTypeManager;

class ShiftController extends AbstractActionController
{
    private $ShiftManager;
    private $ShiftGuardManager;
    private $ShiftTypeManager;
    
    public function __construct(
        ShiftManager $ShiftManager,
        ShiftGuardManager $ShiftGuardManager,
        ShiftTypeManager $ShiftTypeManager
        )
    {
        $this->ShiftManager = $ShiftManager;
        $this->ShiftGuardManager = $ShiftGuardManager;
        $this->ShiftTypeManager= $ShiftTypeManager;
    }
    /**
     * We override the parent class' onDispatch() method to
     * set an alternative layout for all actions in this controller.
     */
    public function onDispatch(MvcEvent $e)
    {
        // Call the base class' onDispatch() first and grab the response
        $response = parent::onDispatch($e);
        
        // Set alternative layout
        $this->layout()->setTemplate('layout/blank.phtml');
        
        // Return the response
        return $response;
    }
    
    
//     public function validShiftTypeAction()
//     {
//         $shift_type_id = $this->params()->fromPost('shift_type_id');
//         $date = $this->params()->fromPost('date');
//         $shift_id= $this->params()->fromPost('shift_id');
//         $where = [
//             ShiftEntity::FILED_DATE => strtotime($date),
//             ShiftEntity::FILED_SHIFT_TYPE_ID => $shift_type_id,
//         ];
//         $count = $this->ShiftManager->MyOrm->count($where);
//         if ($count)
//         {
//             $Entity = $this->ShiftManager->MyOrm->findOne($where);
//             $id = $Entity->getId();
//             return $id == $shift_type_id;
//         }else {
//             $this->ajax()->valid(true);
//         }
//     }
    
    //edit the website infomation
//     public function editAction()
//     {
//         $shift_id = $this->params()->fromRoute('shiftID');
//         //获取用户提交表单
//         $values = $this->params()->fromPost();
//         $guard_ids  = $this->params()->fromPost('guard_ids');
//         $connection = $this->ShiftManager->MyOrm->getConnection();
//         try{
//             $connection->beginTransaction();
            
//             //先更新shifts 数据表中
//             $values[ShiftEntity::FILED_DATE] = strtotime($values[ShiftEntity::FILED_DATE]);
//             //do filter
//             $values = $this->ShiftManager->FormFilter->getFilterValues($values);
//             //执行更新
//             $res = $this->ShiftManager->MyOrm->update($shift_id, $values);
//             if(empty($res))
//             {
//                 throw new \Exception('insert shift error');
//             }
            
//             //先将shift_guard 中关于shift_id 的全部删掉
//             $where = [
//                 ShiftGuardEntity::FILED_SHIFT_ID=>$shift_id
//             ];
//             $res = $this->ShiftGuardManager->MyOrm->delete($where);
//             if(empty($res))
//             {
//                 throw new \Exception('delete shift_guard error');
//             }
//             //然后保存到shift_guard 数据表中
//             foreach ($guard_ids as $key=>$guard_id)
//             {
//                 $values = [
//                     ShiftGuardEntity::FILED_GUARD_ID => $guard_id,
//                     ShiftGuardEntity::FILED_SHIFT_ID => $shift_id,
//                 ];
//                 $res = $this->ShiftGuardManager->MyOrm->insert($values);
//                 if(empty($res))
//                 {
//                     throw new \Exception('insert shift_guard error');
//                 }
//             }
//             $connection->commit();
//             $res = true;
//         }catch (\Exception $e ){
//             $res = false;
//             $connection->rollback();
//         }
//         $this->ajax()->success($res);
//     }
    
    public function addAction()
    {
        //获取用户提交表单
        $values = $this->params()->fromPost();
        $guard_ids = $this->params()->fromPost('guard_ids');
        $date = $this->params()->fromPost('date');
        //获取值班类型信息
        //增加到数据中
        $shift_type_id = $this->params()->fromPost('shift_type_id');
        $ShiftTypeEntity = $this->ShiftTypeManager->MyOrm->findOne($shift_type_id);
        $shfit_type_name = $ShiftTypeEntity->getName();
        $start_time      = $ShiftTypeEntity->getStart_time();
        $end_time        = $ShiftTypeEntity->getEnd_time();
        $is_next_day     = $ShiftTypeEntity->getIs_next_day();
        
        $start_time = $date . ' ' . $start_time;
        $start_time = strtotime($start_time);
        if ($is_next_day) {
            $date = date('Y-m-d', strtotime($date) + 24 * 60 * 60);
        }
        
        $end_time   = $date . ' ' . $end_time;
        $end_time   = strtotime($end_time);
        
        $values[ShiftEntity::FILED_SHIFT_TYPE_NAME] = $shfit_type_name;
        $values[ShiftEntity::FILED_START_TIME] = $start_time;
        $values[ShiftEntity::FILED_END_TIME] = $end_time;
        
        $connection = $this->ShiftManager->MyOrm->getConnection();
        try{
            $connection->beginTransaction(); 
            
            //do filter
            $values = $this->ShiftManager->FormFilter->getFilterValues($values);
            //执行增加操作
            $res = $this->ShiftManager->MyOrm->insert($values);
            $shift_id = $this->ShiftManager->MyOrm->getLastInsertId();
            if(empty($res))
            {
                throw new \Exception('insert shift error');
            }
            //然后保存到shift_guard 数据表中
            foreach ($guard_ids as $key=>$guard_id)
            {
                $values = [
                    ShiftGuardEntity::FILED_GUARD_ID => $guard_id,
                    ShiftGuardEntity::FILED_SHIFT_ID => $shift_id,
                ];
                $res = $this->ShiftGuardManager->MyOrm->insert($values);
                if(empty($res))
                {
                    throw new \Exception('insert shift_guard error');
                }
            }
            $connection->commit();
            $res = true;
        }catch (\Exception $e ){
            $res = false;
            $connection->rollback();
        }
        $this->ajax()->success($res);
    }
    
    public function deleteAction()
    {
        $shift_id = $this->params()->fromRoute('shiftID');
        $res = $this->ShiftManager->MyOrm->delete($shift_id);
        $this->ajax()->success($res);
    }
    
}
