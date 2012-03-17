<?php


/**
 * This class adds structure of 'EMT_CUSTOMER_MESSAGE' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/07/12 22:24:30
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class CustomerMessageMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CustomerMessageMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(CustomerMessagePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(CustomerMessagePeer::TABLE_NAME);
		$tMap->setPhpName('CustomerMessage');
		$tMap->setClassname('CustomerMessage');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_CUSTOMER_MESSAGE_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('TOPIC_ID', 'TopicId', 'INTEGER', true, 10);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'EMT_USER', 'ID', false, 10);

		$tMap->addColumn('SENDER_NAMELASTNAME', 'SenderNamelastname', 'VARCHAR', true, 50);

		$tMap->addColumn('SENDER_EMAIL', 'SenderEmail', 'VARCHAR', true, 80);

		$tMap->addColumn('MESSAGE', 'Message', 'LONGVARCHAR', true, 2000);

		$tMap->addColumn('SENDER_IP', 'SenderIp', 'VARCHAR', false, 20);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // CustomerMessageMapBuilder
