<?php


/**
 * This class adds structure of 'EMT_RESUME_AWARD' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:21
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ResumeAwardMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ResumeAwardMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ResumeAwardPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ResumeAwardPeer::TABLE_NAME);
		$tMap->setPhpName('ResumeAward');
		$tMap->setClassname('ResumeAward');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_RESUME_AWARD_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 16);

		$tMap->addForeignPrimaryKey('RESUME_ID', 'ResumeId', 'INTEGER' , 'EMT_RESUME', 'ID', true, 10);

		$tMap->addColumn('TITLE', 'Title', 'VARCHAR', true, 200);

		$tMap->addColumn('ISSUER', 'Issuer', 'VARCHAR', false, 100);

		$tMap->addColumn('NOTES', 'Notes', 'LONGVARCHAR', false, 2000);

		$tMap->addColumn('YEAR', 'Year', 'VARCHAR', false, 4);

	} // doBuild()

} // ResumeAwardMapBuilder
