<?php


/**
 * This class adds structure of 'EMT_MEDIA_ITEM_FOLDER' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/07/12 22:24:28
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class MediaItemFolderMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.MediaItemFolderMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(MediaItemFolderPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(MediaItemFolderPeer::TABLE_NAME);
		$tMap->setPhpName('MediaItemFolder');
		$tMap->setClassname('MediaItemFolder');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_MEDIA_ITEM_FOLDER_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 15);

		$tMap->addColumn('TYPE_ID', 'TypeId', 'INTEGER', false, 2);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', false, 50);

		$tMap->addColumn('OWNER_ID', 'OwnerId', 'INTEGER', true, 10);

		$tMap->addForeignKey('OWNER_TYPE_ID', 'OwnerTypeId', 'INTEGER', 'EMT_PRIVACY_NODE_TYPE', 'ID', true, 3);

	} // doBuild()

} // MediaItemFolderMapBuilder
