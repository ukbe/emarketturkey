<?php


/**
 * This class adds structure of 'EMT_TIME_SCHEME' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:11:00
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class TimeSchemeMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.TimeSchemeMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(TimeSchemePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(TimeSchemePeer::TABLE_NAME);
		$tMap->setPhpName('TimeScheme');
		$tMap->setClassname('TimeScheme');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_TIME_SCHEME_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 4);

		$tMap->addColumn('START_DATE', 'StartDate', 'TIMESTAMP', true, null);

		$tMap->addColumn('END_DATE', 'EndDate', 'TIMESTAMP', true, null);

		$tMap->addColumn('REPEAT_TYPE_ID', 'RepeatTypeId', 'INTEGER', true, 3);

	} // doBuild()

} // TimeSchemeMapBuilder
