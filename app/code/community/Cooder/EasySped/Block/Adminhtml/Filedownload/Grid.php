<?php
 
class Cooder_EasySped_Block_Adminhtml_Filedownload_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
       	$this->setId('easysped_filedownload_grid');
        // This is the primary key of the database
        $this->setDefaultSort('file_id');
        $this->setDefaultDir('ASC');
       	$this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _getCollectionClass()
    {
        // This is the model we are using for the grid
        return 'easysped/filedownload_collection';
    }
     
    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
	}
 
    protected function _prepareColumns()
    {
        $this->addColumn('file_id', array(
            'header'    => Mage::helper('easysped')->__('File #'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'file_id',
        ));
 
        $this->addColumn('file_name', array(
            'header'    => Mage::helper('easysped')->__('File Name'),
            'align'     =>'left',
            'index'     => 'file_name',
        ));
		
  
        $this->addColumn('created_time', array(
            'header'    => Mage::helper('easysped')->__('Creation Date'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'created_time',
        ));
 
        $this->addColumn('downloaded_time', array(
            'header'    => Mage::helper('easysped')->__('Downloaded Date'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'downloaded_time',
        ));   
 
 
       $this->addColumn('file_status', array(
            'header'    => Mage::helper('easysped')->__('File Status'),
            'align'     => 'left',
            'width'     => '100px',
            'index'     => 'file_status',
        )); 

	 $this->addColumn('action',
                array(
                    'header'    => Mage::helper('easysped')->__('Action'),
                    'width'     => '100px',
                    'type'      => 'action',
                    'getter'     => 'getId',
                    'actions'   => array(
                        array(
                            'caption' => Mage::helper('easysped')->__('Download'),
                            //'onmouseup' => 'easysped_filedownload_gridJsObject.reload();',
                            'url'     => array('base'=>'*/*/download'),
                            'field'   => 'id'
                        )
                    ),
                    'filter'    => false,
                    'sortable'  => false,
                    'index'     => 'stores',
                    'is_system' => true,
            ));
	

        return parent::_prepareColumns();
    }
 
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/download', array('id' => $row->getId()));
    }
 
    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }
 
 
}