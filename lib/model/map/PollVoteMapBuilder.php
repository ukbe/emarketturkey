<?php


/**
 * This class adds structure of 'EMT_POLL_VOTE' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:51
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PollVoteMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PollVoteMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PollVotePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PollVotePeer::TABLE_NAME);
		$tMap->setPhpName('PollVote');
		$tMap->setClassname('PollVote');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_POLL_VOTE_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 15);

		$tMap->addForeignKey('ITEM_ID', 'ItemId', 'INTEGER', 'EMT_POLL_ITEM', 'ID', true, 15);

		$tMap->addForeignKey('CLIENT_USER_ID', 'ClientUserId', 'INTEGER', 'EMT_CLIENT_USER', 'ID', false, 10);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // PollVoteMapBuilder
