<?php


/**
 * This class adds structure of 'EMT_LOGIN' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/07/12 22:24:24
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class LoginMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.LoginMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(LoginPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(LoginPeer::TABLE_NAME);
		$tMap->setPhpName('Login');
		$tMap->setClassname('Login');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_LOGIN_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 10);

		$tMap->addColumn('GUID', 'Guid', 'VARCHAR', true, 36);

		$tMap->addColumn('USERNAME', 'Username', 'VARCHAR', false, 50);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', true, 80);

		$tMap->addColumn('SHA1_PASSWORD', 'Sha1Password', 'VARCHAR', true, 40);

		$tMap->addColumn('SALT', 'Salt', 'VARCHAR', true, 32);

		$tMap->addForeignKey('ROLE_ID', 'RoleId', 'INTEGER', 'EMT_ROLE', 'ID', true, 4);

		$tMap->addColumn('REMINDER_QUESTION', 'ReminderQuestion', 'VARCHAR', true, 50);

		$tMap->addColumn('REMINDER_ANSWER', 'ReminderAnswer', 'VARCHAR', true, 50);

		$tMap->addColumn('STARTUP', 'Startup', 'INTEGER', false, 10);

		$tMap->addColumn('REMEMBER_CODE', 'RememberCode', 'VARCHAR', false, 35);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // LoginMapBuilder
