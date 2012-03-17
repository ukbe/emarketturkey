<?php


/**
 * This class adds structure of 'EMT_GROUP_I18N' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/07/12 22:24:33
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class GroupI18nMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.GroupI18nMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(GroupI18nPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(GroupI18nPeer::TABLE_NAME);
		$tMap->setPhpName('GroupI18n');
		$tMap->setClassname('GroupI18n');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'EMT_GROUP', 'ID', true, 10);

		$tMap->addColumn('DISPLAY_NAME', 'DisplayName', 'VARCHAR', true, 255);

		$tMap->addColumn('ABBREVIATION', 'Abbreviation', 'VARCHAR', false, 50);

		$tMap->addColumn('STRIPPED_DISPLAY_NAME', 'StrippedDisplayName', 'VARCHAR', true, 255);

		$tMap->addPrimaryKey('CULTURE', 'Culture', 'VARCHAR', true, 7);

		$tMap->addColumn('INTRODUCTION', 'Introduction', 'LONGVARCHAR', false, 2000);

		$tMap->addColumn('MEMBER_PROFILE', 'MemberProfile', 'LONGVARCHAR', false, 2000);

		$tMap->addColumn('EVENTS_INTRODUCTION', 'EventsIntroduction', 'LONGVARCHAR', false, 2000);

	} // doBuild()

} // GroupI18nMapBuilder
