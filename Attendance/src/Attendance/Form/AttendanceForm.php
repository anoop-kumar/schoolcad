<?php
namespace Attendance\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class AttendanceForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('attendance');
       // $this->setAttribute('method', 'post');
        $this->setAttributes(array(
            'action' => '/attendanace',
            'method' => 'post',
            'class'  => 'form-horizontal'
        ));
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type'  => 'hidden',
                'value'=>2,
            ),
        ));
        
        $this->add(array(
            'name' => 'security_token',
            'attributes' => array(
                'type'  => 'hidden',
                'value'  => time(),
            ),
        ));
        
        $this->add(array(
            'name' => 'punch_in',
            'attributes' => array(
                'type'  => 'datepicker',
            ),
             'options' => array(
                'label' => 'Punch In',
            ),
        ));
        
        $this->add(array(
            'name' => 'punch_out',
            'attributes' => array(
                'type'  => 'text',
            ),
             'options' => array(
                'label' => 'Punch Out',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'note',
            'attributes' => array(
                'type'  => 'textarea',
            ),
            'options' => array(
                'label' => 'Note',
            ),
        ));
        
//        $this->add(array(
//                    'type' => 'Zend\Form\Element\Select',
//                    'name' => 'payment_type',
//                    'options' => array(
//                        'label' => 'Bezahlung',
//                    ),
//                    'attributes' => array(
//                        'options' => array(
//                            0 => 'Nurerweisung',
//                            1 => 'NurPaypal',
//                            2 => 'NurBarzahlung im Voraus',
//                            3 => 'NurBarzahlung am Bus',
//                        ),
//                        'value' => 2 //set selected to "public"
//                    )
//                ));
        $hours = new Element\Select('hours');
        $hours->setLabel('Calculated Hours');
        $hours->setValueOptions(range(0,24));       
        $this->add($hours);
        //$hours->getLabel()
                
        $overtime = new Element\Select('overtime');
        $overtime->setLabel('Include Overtime');
        $overtime->setValueOptions(array('No','Yes'));
        $this->add($overtime);
        
        $approved = new Element\Select('approved');
        $approved->setLabel('Approved');
        $approved->setValueOptions(array('No','Yes'));
        $this->add($approved);
        
        $month_names = array("","January","February","March","April","May","June","July","August","September","October","November","December"); 
        //array_shift($month_names);
        $month = new Element\Select('month');
        $month->setLabel('Month');
        $month->setValueOptions($month_names);
        $this->add($month);
                
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
                'class' => 'btn btn-success',
            ),
        ));
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
