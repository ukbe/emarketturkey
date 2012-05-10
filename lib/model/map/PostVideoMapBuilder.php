<?php


/**
 * This class adds structure of 'EMT_POST_VIDEO' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:54
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PostVideoMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PostVideoMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PostVideoPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PostVideoPeer::TABLE_NAME);
		$tMap->setPhpName('PostVideo');
		$tMap->setClassname('PostVideo');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_POST_VIDEO_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('URL', 'Url', 'VARCHAR', true, 500);

		$tMap->addColumn('TITLE', 'Title', 'VARCHAR', false, 500);

		$tMap->addColumn('MESSAGE', 'Message', 'VARCHAR', false, 1024);

		$tMap->addColumn('VIDEO_ID', 'VideoId', 'VARCHAR', false, 50);

		$tMap->addColumn('SERVICE_ID', 'ServiceId', 'INTEGER', false, 2);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // PostVideoMapBuilder
