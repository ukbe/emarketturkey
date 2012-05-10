<?php


/**
 * This class adds structure of 'EMT_CONTACT' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:09
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ContactMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ContactMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ContactPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ContactPeer::TABLE_NAME);
		$tMap->setPhpName('Contact');
		$tMap->setClassname('Contact');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_CONTACT_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', false, 80);

		$tMap->addColumn('GTALK', 'Gtalk', 'VARCHAR', false, 50);

		$tMap->addColumn('MSN', 'Msn', 'VARCHAR', false, 50);

		$tMap->addColumn('YAHOO', 'Yahoo', 'VARCHAR', false, 50);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // ContactMapBuilder
