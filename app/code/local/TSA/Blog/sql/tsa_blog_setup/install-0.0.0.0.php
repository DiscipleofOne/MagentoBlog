<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */


$installer->startSetup();



$table = $installer->getConnection()
//    ->dropTable($installer->getTable('tsa_blog/comment'))
//    ->dropTable($installer->getTable('tsa_blog/post'))

    ->newTable($installer->getTable('tsa_blog/post'))

    ->addColumn('blog_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Blog ID')
    ->addColumn('author', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
    ), 'Author' )
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
    ), 'Title')
    ->addColumn('created_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => false,
    ), 'Created Date')
    ->addColumn('published_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true,
    ), 'Published Date')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
    ))
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
    ), 'Content')
    ->addColumn('published', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable' => false,
    ), 'Published')
    ->setComment('Blog Main Table');

$installer->getConnection()->createTable($table);

$table = $installer->getConnection()

    ->newTable($installer->getTable('tsa_blog/comment'))

    ->addColumn('comment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Comment ID')
    ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Comment')
    ->addColumn('first_name', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'First Name')
    ->addColumn('last_name', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Last Name')
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Email')
    ->addColumn('approved', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable' => true,
    ), 'Approved')
    ->addColumn('blog_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
    ), 'Blog Id')

    ->addForeignKey($installer->getFkName('tsa_blog/comment', 'blog_id', 'tsa_blog/post', 'blog_id'),
        'blog_id', $installer->getTable('tsa_blog/post'), 'blog_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Blog Comment Table');


$installer->getConnection()->createTable($table);


$installer->endSetup();



