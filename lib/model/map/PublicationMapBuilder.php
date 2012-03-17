<?php


/**
 * This class adds structure of 'EMT_PUBLICATION' table to 'propel' DatabaseMap object.
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
class PublicationMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PublicationMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PublicationPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PublicationPeer::TABLE_NAME);
		$tMap->setPhpName('Publication');
		$tMap->setClassname('Publication');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_PUBLICATION_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addForeignKey('AUTHOR_ID', 'AuthorId', 'INTEGER', 'EMT_AUTHOR', 'ID', true, 10);

		$tMap->addColumn('TYPE_ID', 'TypeId', 'INTEGER', true, 5);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 255);

		$tMap->addForeignKey('CATEGORY_ID', 'CategoryId', 'INTEGER', 'EMT_PUBLICATION_CATEGORY', 'ID', true, 10);

		$tMap->addColumn('ACTIVE', 'Active', 'BOOLEAN', false, 1);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

		$tMap->addForeignKey('SOURCE_ID', 'SourceId', 'INTEGER', 'EMT_PUBLICATION_SOURCE', 'ID', true, 10);

		$tMap->addColumn('DEFAULT_LANG', 'DefaultLang', 'VARCHAR', false, 7);

		$tMap->addColumn('FEATURED_TYPE', 'FeaturedType', 'INTEGER', false, 3);

	} // doBuild()

} // PublicationMapBuilder
