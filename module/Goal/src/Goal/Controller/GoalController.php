<?php
/*
 * @copyright Copyright (c) 2013 SAVAGEBYTES
 */

namespace Goal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Goal\Model\Goal;        
use Goal\Form\GoalForm; 

class GoalController extends AbstractActionController
{
    protected $goalTable;
    
    public function indexAction()
    {
                return new ViewModel(array(
            'goals' => $this->getGoalTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new GoalForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $goal = new Goal();
            $form->setInputFilter($goal->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $goal->exchangeArray($form->getData());
                $this->getGoalTable()->saveGoal($goal);

                
                return $this->redirect()->toRoute('goal');
            }
        }
        return array('form' => $form);
    }

public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('goal', array(
                'action' => 'add'
            ));
        }
        $goal = $this->getGoalTable()->getGoal($id);

        $form  = new GoalForm();
        $form->bind($goal);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($goal->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getGoalTable()->saveGoal($form->getData());

                // Redirect to list of goals
                return $this->redirect()->toRoute('goal');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('goal');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getGoalTable()->deleteGoal($id);
            }

            return $this->redirect()->toRoute('goal');
        }

        return array(
            'id'    => $id,
            'goal' => $this->getGoalTable()->getGoal($id)
        );
    }
    
        public function getGoalTable()
    {
        if (!$this->goalTable) {
            $sm = $this->getServiceLocator();
            $this->goalTable = $sm->get('Goal\Model\GoalTable');
        }
        return $this->goalTable;
    }
    
}