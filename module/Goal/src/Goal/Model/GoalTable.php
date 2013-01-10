<?php
/*
 * @copyright Copyright (c) 2013 SAVAGEBYTES
 */

namespace Goal\Model;

use Zend\Db\TableGateway\TableGateway;

class GoalTable
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

    public function getGoal($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveGoal(Goal $goal)
    {
        $data = array(
            'goal' => $goal->goal,
            'description'  => $goal->description,
        );

        $id = (int)$goal->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getGoal($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteGoal($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}