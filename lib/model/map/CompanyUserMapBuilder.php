<?php


/**
 * This class adds structure of 'EMT_COMPANY_USER' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:17
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class CompanyUserMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CompanyUserMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(CompanyUserPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(CompanyUserPeer::TABLE_NAME);
		$tMap->setPhpName('CompanyUser');
		$tMap->setClassname('CompanyUser');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_COMPANY_USER_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addForeignKey('COMPANY_ID', 'CompanyId', 'INTEGER', 'EMT_COMPANY', 'ID', true, 10);

		$tMap->addColumn('OBJECT_ID', 'ObjectId', 'INTEGER', false, 10);

		$tMap->addForeignKey('ROLE_ID', 'RoleId', 'INTEGER', 'EMT_ROLE', 'ID', true, 4);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addForeignKey('OBJECT_TYPE_ID', 'ObjectTypeId', 'INTEGER', 'EMT_PRIVACY_NODE_TYPE', 'ID', true, 3);

		$tMap->addColumn('STATUS', 'Status', 'INTEGER', false, 2);

	} // doBuild()

} // CompanyUserMapBuilder
