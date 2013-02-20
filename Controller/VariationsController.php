<?php
App::uses('AppController', 'Controller');
/**
 * Variations Controller
 *
 * @property Variation $Variation
 */
class VariationsController extends AppController {


/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->Variation->recursive = 0;
    $this->set('variations', $this->paginate());
  }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
  public function view($id = null) {
    $this->Variation->id = $id;
    if (!$this->Variation->exists()) {
      throw new NotFoundException(__('Invalid variation'));
    }
    $this->set('variation', $this->Variation->read(null, $id));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Variation->create();
      if ($this->Variation->save($this->request->data)) {
        if ($this->request->data['Variation']['computer_id'] != '') {
          $computer = $this->Variation->Cluster->Computer->read(null, $this->request->data['Variation']['computer_id']);
          $script_path = $this->getScriptPath();
          $cow_path = $this->getSetting('cow_path');
          $ret = shell_exec("sudo {$script_path}/copyvariation.sh {$cow_path} {$computer['Computer']['name']} {$this->request->data['Variation']['cow']}");
        }
        $this->Session->setFlash(__('The variation has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The variation could not be saved. Please, try again.'));
      }
    }
    $clusters = $this->Variation->Cluster->find('list');
    $computers = $this->Variation->Cluster->Computer->find('list');
    $this->set(compact('clusters', 'computers'));
  }

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
  public function edit($id = null) {
    $this->Variation->id = $id;
    if (!$this->Variation->exists()) {
      throw new NotFoundException(__('Invalid variation'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Variation->save($this->request->data)) {
        if ($this->request->data['Variation']['computer_id'] != '') {
          $computer = $this->Variation->Cluster->Computer->read(null, $this->request->data['Variation']['computer_id']);
          $script_path = $this->getScriptPath();
          $cow_path = $this->getSetting('cow_path');
          $ret = shell_exec("sudo {$script_path}/copyvariation.sh {$cow_path} {$computer['Computer']['name']} {$this->request->data['Variation']['cow']}");
        }
        $this->Session->setFlash(__('The variation has been saved'));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The variation could not be saved. Please, try again.'));
      }
    } else {
      $this->request->data = $this->Variation->read(null, $id);
    }
    $clusters = $this->Variation->Cluster->find('list');
    $computers = $this->Variation->Cluster->Computer->find('list', array('conditions' => array('cluster_id' => $this->request->data['Variation']['cluster_id'])));
    $this->set(compact('clusters', 'computers'));
  }

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
  public function delete($id = null) {
    if (!$this->request->is('post')) {
      throw new MethodNotAllowedException();
    }
    $this->Variation->id = $id;
    if (!$this->Variation->exists()) {
      throw new NotFoundException(__('Invalid variation'));
    }
    $variation = $this->Variation->read(null, $id);
    if ($this->Variation->delete()) {
      $script_path = $this->getScriptPath();
      $cow_path = $this->getSetting('cow_path');
      $ret = shell_exec("sudo {$script_path}/deletevariation.sh {$cow_path} {$variation['Variation']['cow']}");
      $this->Session->setFlash(__('Variation deleted'));
      $this->redirect(array('action' => 'index'));
    }
    $this->Session->setFlash(__('Variation was not deleted'));
    $this->redirect(array('action' => 'index'));
  }
}
