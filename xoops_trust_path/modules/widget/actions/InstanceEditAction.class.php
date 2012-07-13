<?php
/**
 * @file
 * @package widget
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
	exit;
}

require_once WIDGET_TRUST_PATH . '/class/AbstractEditAction.class.php';

/**
 * Widget_InstanceEditAction
**/
class Widget_InstanceEditAction extends Widget_AbstractEditAction
{
	const DATANAME = 'instance';

	/**
	 * _getType
	 *
	 * @param	void
	 *
	 * @return	int
	**/
	protected function _getType()
	{
		return $this->mRoot->mContext->mRequest->getRequest('type');
	}

	/**
	 * prepare
	 * 
	 * @param   void
	 * 
	 * @return  bool
	**/
	public function prepare()
	{
		parent::prepare();
		if($this->mObject->isNew()){
			$this->mObject->set('type', $this->_getType());
		}
		$this->mObject->loadPlugin();
		$this->_setupAccessController('instance');
		 return true;
	}

	/**
	 * executeViewInput
	 * 
	 * @param   XCube_RenderTarget  &$render
	 * 
	 * @return  void
	**/
	public function executeViewInput(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_instance_edit.html');
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('dataname', self::DATANAME);
		$render->setAttribute('optionFormPath', WIDGET_TRUST_PATH.'/plugins/'.$this->mObject->get('type').'/option_form.html');

		$render->setAttribute('accessController',$this->mAccessController['main']);
	}

	public function _doExecute()
	{
		if(parent::_doExecute()){
			$this->mObject->loadOptionValues();
			if(Widget_Utils::installWidgetTemplate($this->mObject)){
				return WIDGET_FRAME_VIEW_SUCCESS;
			}
		}
		return WIDGET_FRAME_VIEW_ERROR;
	}
}
?>
