<?php


/**
 * This class adds structure of 'EMT_COMPANY' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/07/12 22:24:26
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class CompanyMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CompanyMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(CompanyPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(CompanyPeer::TABLE_NAME);
		$tMap->setPhpName('Company');
		$tMap->setClassname('Company');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_COMPANY_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 255);

		$tMap->addForeignKey('BUSINESS_TYPE_ID', 'BusinessTypeId', 'INTEGER', 'EMT_BUSINESS_TYPE', 'ID', true, 4);

		$tMap->addForeignKey('PROFILE_ID', 'ProfileId', 'INTEGER', 'EMT_COMPANY_PROFILE', 'ID', false, 10);

		$tMap->addForeignKey('SECTOR_ID', 'SectorId', 'INTEGER', 'EMT_BUSINESS_SECTOR', 'ID', true, 4);

		$tMap->addColumn('URL', 'Url', 'VARCHAR', false, 255);

		$tMap->addColumn('BRANDS', 'Brands', 'VARCHAR', false, 255);

		$tMap->addColumn('COMPANY_EMAIL', 'CompanyEmail', 'VARCHAR', false, 80);

		$tMap->addColumn('MEMBER_TYPE', 'MemberType', 'INTEGER', false, 2);

		$tMap->addColumn('INTERESTED_IN_B2B', 'InterestedInB2b', 'BOOLEAN', false, 1);

		$tMap->addColumn('INTERESTED_IN_HR', 'InterestedInHr', 'BOOLEAN', false, 1);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('AVAILABLE', 'Available', 'BOOLEAN', false, 1);

		$tMap->addColumn('BLOCKED', 'Blocked', 'BOOLEAN', false, 1);

		$tMap->addColumn('IS_FEATURED', 'IsFeatured', 'BOOLEAN', false, 1);

	} // doBuild()

} // CompanyMapBuilder
