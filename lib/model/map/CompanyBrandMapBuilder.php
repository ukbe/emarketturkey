<?php


/**
 * This class adds structure of 'EMT_COMPANY_BRAND' table to 'propel' DatabaseMap object.
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
class CompanyBrandMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.CompanyBrandMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(CompanyBrandPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(CompanyBrandPeer::TABLE_NAME);
		$tMap->setPhpName('CompanyBrand');
		$tMap->setClassname('CompanyBrand');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_COMPANY_BRAND_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addForeignKey('COMPANY_ID', 'CompanyId', 'INTEGER', 'EMT_COMPANY', 'ID', true, 10);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 100);

		$tMap->addColumn('TARGET_MARKETS', 'TargetMarkets', 'VARCHAR', false, 50);

	} // doBuild()

} // CompanyBrandMapBuilder
