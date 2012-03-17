<?php


/**
 * This class adds structure of 'EMT_PUBLICATION_SOURCE_I18N' table to 'propel' DatabaseMap object.
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
class PublicationSourceI18nMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PublicationSourceI18nMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PublicationSourceI18nPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PublicationSourceI18nPeer::TABLE_NAME);
		$tMap->setPhpName('PublicationSourceI18n');
		$tMap->setClassname('PublicationSourceI18n');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'EMT_PUBLICATION_SOURCE', 'ID', true, 10);

		$tMap->addPrimaryKey('CULTURE', 'Culture', 'VARCHAR', true, 7);

		$tMap->addColumn('DISPLAY_NAME', 'DisplayName', 'VARCHAR', true, 255);

		$tMap->addColumn('STRIPPED_DISPLAY_NAME', 'StrippedDisplayName', 'VARCHAR', true, 255);

		$tMap->addColumn('SHORT_DESCRIPTION', 'ShortDescription', 'VARCHAR', false, 100);

		$tMap->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 512);

	} // doBuild()

} // PublicationSourceI18nMapBuilder
