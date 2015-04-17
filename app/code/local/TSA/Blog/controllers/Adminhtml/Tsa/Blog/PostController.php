<?php

class TSA_Blog_Adminhtml_Tsa_Blog_PostController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('tsa_blog/post')
            ->_addBreadcrumb(Mage::helper('tsa_blog')->__('TSA Blog'), Mage::helper('tsa_blog')->__('TSA Blog'))
            ->_addBreadcrumb(Mage::helper('tsa_blog')->__('Manage Posts'), Mage::helper('tsa_blog')->__('Manage Posts'));
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('TSA Blog'))
            ->_title($this->__('Posts'))
            ->_title($this->__('Manage Manage Posts'));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new CMS page
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }


    /**
     * Edit CMS page
     */
    public function editAction()
    {
        $this->_title($this->__('Blog'))
            ->_title($this->__('Posts'))
            ->_title($this->__('Manage Blog Posts'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('blog_id');
        $model = Mage::getModel('tsa_blog/post');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('tsa_blog')->__('This blog post no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Blog Post'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('tsa_blog_post', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('tsa_blog')->__('Edit Blog Post')
                    : Mage::helper('tsa_blog')->__('New Blog Post'),
                $id ? Mage::helper('tsa_blog')->__('Edit Blog Post')
                    : Mage::helper('tsa_blog')->__('New Blog Post'));
        $this->renderLayout();
    }


    /**
     * Save action
     */
    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            //init model and set data
            $model = Mage::getModel('tsa_blog/post');


            // Updates an existing model
            if ($id = $this->getRequest()->getParam('blog_id')) {
                $model->load($id);
            }

            if(isset($_FILES['image']) and (file_exists($_FILES['image']['tmp_name']))) {
                try{
                    $uploader = new Varien_File_Uploader('image');

                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));

                    $uploader->setAllowRenameFiles(true);

                    $uploader->setFilesDispersion(true);

                    $path = Mage::getBaseDir('media') . DS . 'tsa_blog_posts' . DS . 'images' . DS;

                    $uploader->save( $path, $_FILES['image']['name']);


                    $data['image']= 'tsa_blog_posts' . DS . 'images' . $uploader->getUploadedFileName();

                } catch(Exception $e){}
            }
            else{
                if(isset($data['image']['delete']) && $data['image']['delete'] == 1)
                    $data['image'] = '';
                else
                    unset($data['image']);

            }


            $model->setData($data);

            Mage::dispatchEvent('tsa_blog_post_prepare_save', array('tsa_blog_post' => $model, 'request' => $this->getRequest()));

            // try to save it
            try {
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('tsa_blog')->__('The blog post has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('blog_id' => $model->getId(), '_current' => true));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('tsa_blog')->__('An error occurred while saving the post.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('blog_id' => $this->getRequest()->getParam('blog_id')));
            return;
        }
        $this->_redirect('*/*/');
    }


    public function massPublishAction()
    {
        $this->_massActionHelper('publish');
    }

    public function massUnpublishAction()
    {
        $this->_massActionHelper('unpublish');
    }


    public function massDeleteAction()
    {
        $this->_massActionHelper('delete');
    }

    protected function _massActionHelper($action)
    {
        $blogIds = $this->getRequest()->getParam('blog_id');

        if (!is_array($blogIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tsa_blog')->__('Please select post(s).'));
        } else {
            try {
                $blogPostModel = Mage::getModel('tsa_blog/post');

                foreach ($blogIds as $blogPostID) {
                    $blogPostModel->load($blogPostID);
                    if(0 == strcmp('delete',$action)) {
                        $blogPostModel->delete();
                        $action='delet';
                    }
                    else if(0 == strcmp($action,'publish')){
                        $blogPostModel->load($blogPostID)->addData(array('published' => '1'))->save();
                    }
                    else if(0 == strcmp($action,'unpublish')){
                        $blogPostModel->load($blogPostID)->addData(array('published' => '0'))->save();
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('tsa_blog')->__('Total of %d record(s) were ' . $action . 'ed.', count($blogIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}