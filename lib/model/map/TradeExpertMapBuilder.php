<?php


/**
 * This class adds structure of 'EMT_TRADE_EXPERT' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/07/12 22:24:37
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class TradeExpertMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.TradeExpertMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(TradeExpertPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(TradeExpertPeer::TABLE_NAME);
		$tMap->setPhpName('TradeExpert');
		$tMap->setClassname('TradeExpert');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_TRADE_EXPERT_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('HOLDER_ID', 'HolderId', 'INTEGER', true, 10);

		$tMap->addForeignKey('HOLDER_TYPE_ID', 'HolderTypeId', 'INTEGER', 'EMT_PRIVACY_NODE_TYPE', 'ID', true, 3);

		$tMap->addColumn('STATUS', 'Status', 'INTEGER', false, 2);

		$tMap->addColumn('DEFAULT_LANG', 'DefaultLang', 'VARCHAR', false, 7);

		$tMap->addColumn('IS_FEATURED', 'IsFeatured', 'BOOLEAN', false, 1);

	} // doBuild()

} // TradeExpertMapBuilder
