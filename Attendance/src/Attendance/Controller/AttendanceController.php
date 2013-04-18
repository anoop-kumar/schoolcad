<?php
namespace Attendance\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//Form
use Attendance\Model\Attendance;          // <-- Add this import
use Attendance\Form\AttendanceForm;       // <-- Add this import

class AttendanceController extends AbstractActionController
{
    protected $attendanceTable;
    
    public function getAttendanceTable()
    {
        if (!$this->attendanceTable) {
            $sm = $this->getServiceLocator();
            $this->attendanceTable = $sm->get('Attendance\Model\AttendanceTable');
        }
        return $this->attendanceTable;
    }
    
    public function indexAction()
    {                
        return new ViewModel(array(            
            'attendances' => $this->getAttendanceTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new AttendanceForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $attendance = new Attendance();
            $form->setInputFilter($attendance->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $attendance->exchangeArray($form->getData());
                $this->getAttendanceTable()->saveAttendance($attendance);

                // Redirect to list of Attendances
                return $this->redirect()->toRoute('attendance');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
         // Add content to this method:    
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('attendance', array(
                'action' => 'add'
            ));
        }

        // Get the Attendance with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            
            $attendance = $this->getAttendanceTable()->getAttendance($id);
        }
        catch (Exception $ex) {
            
            return $this->redirect()->toRoute('attendance', array(
                'action' => 'index'
            ));
        }

        $form  = new AttendanceForm();                
        $form->bind($attendance);
        
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($attendance->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAttendanceTable()->saveAttendance($form->getData());

                // Redirect to list of attendances
                return $this->redirect()->toRoute('attendance');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
   
    }

    // Delete any records
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('attendance');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAttendanceTable()->deleteAttendance($id);
            }

            // Redirect to list of attendances
            return $this->redirect()->toRoute('attendance');
        }

        return array(
            'id'    => $id,
            'attendance' => $this->getAttendanceTable()->getAttendance($id)
        );
    }
}