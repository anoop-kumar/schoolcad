<?php
namespace Attendance\Model;

use Zend\Db\TableGateway\TableGateway;

class AttendanceTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getAttendance($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
       
        return $row;
    }

    public function saveAttendance(Attendance $attendance)
    {
        
        $data = array(
            'user_id' => $attendance->user_id,
            'punch_in' => $attendance->punch_in,
            'punch_out' => $attendance->punch_out,
            'note' => $attendance->note,
            'hours' => $attendance->hours,
            'overtime' => $attendance->overtime,
            'month' => $attendance->month,
            'approved' => $attendance->approved,
        );

        $id = (int)$attendance->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAttendance($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteAttendance($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
