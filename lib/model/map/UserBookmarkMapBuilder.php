<?php


/**
 * This class adds structure of 'EMT_USER_BOOKMARK' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:45
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UserBookmarkMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UserBookmarkMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(UserBookmarkPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(UserBookmarkPeer::TABLE_NAME);
		$tMap->setPhpName('UserBookmark');
		$tMap->setClassname('UserBookmark');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_USER_BOOKMARK_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'EMT_USER', 'ID', true, 10);

		$tMap->addColumn('ITEM_ID', 'ItemId', 'INTEGER', true, 10);

		$tMap->addForeignKey('ITEM_TYPE_ID', 'ItemTypeId', 'INTEGER', 'EMT_PRIVACY_NODE_TYPE', 'ID', true, 3);

		$tMap->addColumn('TYPE_ID', 'TypeId', 'INTEGER', true, 3);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // UserBookmarkMapBuilder
