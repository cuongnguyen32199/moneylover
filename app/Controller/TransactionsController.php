<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class TransactionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$currentMonth = date('m');
		$currentYear = date('Y');
		$this->set('currentMonth',$currentMonth);
		$this->set('currentYear', $currentYear);
		$user_info = $this->get_user();
		$this->Transaction->recursive = 0;
		$this->paginate = array(
			'order' => array('create_date' => 'desc'),
			'limit' => 10,
			'conditions' => array('Transaction.user_id' => $user_info['id']),
			'paramType' => 'querystring'
			);
		$this->Paginator->settings = $this->paginate;
		$this->set('transactions', $this->paginate());
		$this->loadModel('Wallet');
		$wallets = $this->Wallet->find('all', array(
			'conditions' => array('user_id' => $user_info['id'])
			));
		$this->set('wallets',$wallets);
		$currDate = date("m");
		$this->set('currDate', $currDate);
		//pr($currDateTime); exit;
		$inflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $currDate,
					'Category.category_type' => array('Thu Nhập','Nợ')
					)
			));
		$this->set('inflow', $inflow);
		//pr($inflow); exit;
		$outflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $currDate,
					'Category.category_type' => array('Chi Tiêu', 'Cho Vay')
					)
			));
		$this->set('outflow', $outflow);
		//pr($outflow); exit;
		$netIncome = $inflow['0']['0']['Total'] - $outflow['0']['0']['Total']; //Thu nhập ròng
		$this->set('netIncome', $netIncome);

		$months = $this->Transaction->find('all', array(
			'fields' => array('month(create_date) AS Month'),
			'group' => array('month(create_date)')
			));
		//pr($months['0']['0']['Month']); exit;
		//pr($netIncome); exit;
		//pr($this->paginate()); exit;
	}

/**
* report method
*
*
*/
	public function report($month,$year){
		$inflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Thu Nhập','Nợ')
					)
			));
		$this->set('inflow', $inflow);
		//pr($inflow); exit;
		$outflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Chi Tiêu', 'Cho Vay')
					)
			));
		$this->set('outflow', $outflow);
		//pr($outflow); exit;
		$netIncome = $inflow['0']['0']['Total'] - $outflow['0']['0']['Total']; //Thu nhập ròng
		$this->set('netIncome', $netIncome);

		$most_outflow = $this->Transaction->find('first', array(
			'conditions' => array(
				'month(create_date)' => $month,
				'year(create_date)' => $year,
				'Category.category_type' => array('Chi Tiêu', 'Cho Vay')
				),
			'order' => array('amount' => 'desc')
			));
		$this->set('most_outflow', $most_outflow);

		$details_outflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total', 'Category.category_name'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Chi Tiêu', 'Cho Vay')
					),
				'group' => array('Category.category_name')
			));
		$this->set('details_outflow', $details_outflow);
		//pr($details); exit;
		$details_inflow = $this->Transaction->find('all', array(
				'fields' => array('SUM(amount) AS Total', 'Category.category_name'),
				'conditions' => array(
					'month(create_date)' => $month,
					'year(create_date)' => $year,
					'Category.category_type' => array('Thu Nhập','Nợ')
					),
				'group' => array('Category.category_name')
			));
		//pr($detail_inflow); exit;
		$this->set('details_inflow', $details_inflow);
		if(!empty($this->request->data)){
			//pr($this->request->data); exit;
			$this->redirect('/bao-cao-hang-thang/'.$this->request->data['Transaction']['date']['month'].'/'.$this->request->data['Transaction']['date']['year']);
		}
		$this->set('month', $month);
		//pr($year); exit;
		$this->set('year', $year);
	}




/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($slug = null) {
		$transactions = $this->Transaction->find('first', array('conditions' => array('Transaction.slug' => $slug)));
		if (!$transactions) {
			throw new NotFoundException(__(' Không tìm thấy trang bạn yêu cầu.'));
		} else{
			$this->set('transaction', $transactions);
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			
			$this->Transaction->create();
			//pr($this->request->data); exit;
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash('Lưu giao dịch thành công.', 'default', array('class' => 'alert alert-info'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Giao dịch chưa được lưu. Vui lòng thử lại.', 'default', array('class' => 'alert alert-danger'));
			}
		}
		$user_info = $this->get_user();
		$wallets = $this->Transaction->Wallet->find('list',array(
			'conditions' => array('user_id' => $user_info['id'])
			));
		$categories = $this->Transaction->Category->find('list');
		$category_type = $this->Transaction->Category->find('list', array(
			'group' => array('category_type')
			));
		$users = $this->Transaction->User->find('list',array(
			'conditions' => array('id' => $user_info['id'])));
		$this->set(compact('wallets','users', 'categories', 'category_type'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($slug = null) {
		if (!$this->Transaction->find('first', array('conditions' => array('Transaction.slug' => $slug)))) {
			throw new NotFoundException(__('Không tìm thấy trang bạn yêu cầu'));
		}
		if ($this->request->is(array('post', 'put'))) {
			//pr($this->request->data); exit;
			if ($this->Transaction->save($this->request->data)) {
					$this->Session->setFlash('Lưu giao dịch thành công.', 'default', array('class' => 'alert alert-info'));
					return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Giao dịch chưa được lưu. Vui lòng thử lại.', 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$this->request->data = $this->Transaction->find('first', array('conditions' => array('Transaction.slug' => $slug)));
		}
		$user_info = $this->get_user();
		$wallets = $this->Transaction->Wallet->find('list',array(
			'conditions' => array('user_id' => $user_info['id'])
			));
		
		$categories = $this->Transaction->Category->find('list');
		$this->set(compact('wallets', 'categories'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Transaction->delete()) {
			$this->Session->setFlash('Giao dịch đã được xóa', 'default', array('class' => 'alert alert-info'));
		} else {
			$this->Session->setFlash('Giao dịch chưa được xóa. Vui lòng thử lại.', 'default', array('class' => 'alert alert-info'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
