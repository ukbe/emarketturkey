<?php


/**
 * This class adds structure of 'EMT_SERVICE' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/07/12 22:24:31
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ServiceMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ServiceMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ServicePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ServicePeer::TABLE_NAME);
		$tMap->setPhpName('Service');
		$tMap->setClassname('Service');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_SERVICE_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('GUID', 'Guid', 'VARCHAR', true, 36);

		$tMap->addForeignKey('APPLICATION_ID', 'ApplicationId', 'INTEGER', 'EMT_APPLICATION', 'ID', true, 10);

		$tMap->addForeignKey('APPLIES_TO_TYPE_ID', 'AppliesToTypeId', 'INTEGER', 'EMT_PRIVACY_NODE_TYPE', 'ID', true, 3);

		$tMap->addColumn('ACTIVE', 'Active', 'BOOLEAN', true, 1);

		$tMap->addColumn('STATUS', 'Status', 'INTEGER', false, 3);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('DETAIL_PARTIAL', 'DetailPartial', 'VARCHAR', false, 50);

		$tMap->addForeignKey('IMAGE_ID', 'ImageId', 'INTEGER', 'EMT_MEDIA_ITEM', 'ID', false, 15);

	} // doBuild()

} // ServiceMapBuilder
