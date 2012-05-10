<?php


/**
 * This class adds structure of 'EXT_GEONAME_COUNTRY' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:24
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class GeonameCountryMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.GeonameCountryMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(GeonameCountryPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(GeonameCountryPeer::TABLE_NAME);
		$tMap->setPhpName('GeonameCountry');
		$tMap->setClassname('GeonameCountry');

		$tMap->setUseIdGenerator(false);

		$tMap->addColumn('ISO', 'Iso', 'VARCHAR', false, 150);

		$tMap->addColumn('ISO3', 'Iso3', 'VARCHAR', false, 5);

		$tMap->addColumn('ISO_NUMERIC', 'IsoNumeric', 'INTEGER', false, 3);

		$tMap->addColumn('FIPS', 'Fips', 'VARCHAR', false, 2);

		$tMap->addColumn('COUNTRY', 'Country', 'VARCHAR', false, 200);

		$tMap->addColumn('CAPITAL', 'Capital', 'VARCHAR', false, 200);

		$tMap->addColumn('AREA', 'Area', 'INTEGER', false, 8);

		$tMap->addColumn('POPULATION', 'Population', 'INTEGER', false, 10);

		$tMap->addColumn('CONTINENT', 'Continent', 'VARCHAR', false, 2);

		$tMap->addColumn('TLD', 'Tld', 'VARCHAR', false, 10);

		$tMap->addColumn('CURRENCY_CODE', 'CurrencyCode', 'VARCHAR', false, 10);

		$tMap->addColumn('CURRENCY_NAME', 'CurrencyName', 'VARCHAR', false, 20);

		$tMap->addColumn('PHONE', 'Phone', 'VARCHAR', false, 20);

		$tMap->addColumn('POSTAL_CODE_FORMAT', 'PostalCodeFormat', 'VARCHAR', false, 200);

		$tMap->addColumn('POSTAL_CODE_REGEX', 'PostalCodeRegex', 'VARCHAR', false, 200);

		$tMap->addColumn('LANGUAGES', 'Languages', 'VARCHAR', false, 60);

		$tMap->addForeignPrimaryKey('GEONAME_ID', 'GeonameId', 'INTEGER' , 'EXT_GEONAME', 'GEONAME_ID', true, 7);

		$tMap->addColumn('NEIGHBOURS', 'Neighbours', 'VARCHAR', false, 50);

		$tMap->addColumn('EQUIVALENT_FIPS_CODE', 'EquivalentFipsCode', 'VARCHAR', false, 20);

	} // doBuild()

} // GeonameCountryMapBuilder
