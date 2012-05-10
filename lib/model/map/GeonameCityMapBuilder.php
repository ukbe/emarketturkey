<?php


/**
 * This class adds structure of 'EXT_GEONAME' table to 'propel' DatabaseMap object.
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
class GeonameCityMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.GeonameCityMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(GeonameCityPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(GeonameCityPeer::TABLE_NAME);
		$tMap->setPhpName('GeonameCity');
		$tMap->setClassname('GeonameCity');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('GEONAME_ID', 'GeonameId', 'INTEGER', true, 7);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', false, 200);

		$tMap->addColumn('ASCIINAME', 'Asciiname', 'VARCHAR', false, 200);

		$tMap->addColumn('ALTERNATENAMES', 'Alternatenames', 'LONGVARCHAR', false, 2000);

		$tMap->addColumn('LATITUDE', 'Latitude', 'DECIMAL', false, 19);

		$tMap->addColumn('LONGITUDE', 'Longitude', 'DECIMAL', false, 19);

		$tMap->addColumn('FEATURE_CLASS', 'FeatureClass', 'VARCHAR', false, 5);

		$tMap->addColumn('FEATURE_CODE', 'FeatureCode', 'VARCHAR', false, 10);

		$tMap->addColumn('COUNTRY_CODE', 'CountryCode', 'VARCHAR', false, 5);

		$tMap->addColumn('CC2', 'Cc2', 'VARCHAR', false, 60);

		$tMap->addColumn('ADMIN1_CODE', 'Admin1Code', 'VARCHAR', false, 20);

		$tMap->addColumn('ADMIN2_CODE', 'Admin2Code', 'VARCHAR', false, 80);

		$tMap->addColumn('ADMIN3_CODE', 'Admin3Code', 'VARCHAR', false, 20);

		$tMap->addColumn('ADMIN4_CODE', 'Admin4Code', 'VARCHAR', false, 20);

		$tMap->addColumn('POPULATION', 'Population', 'INTEGER', false, null);

		$tMap->addColumn('ELEVATION', 'Elevation', 'INTEGER', false, null);

		$tMap->addColumn('GTOPO30', 'Gtopo30', 'INTEGER', false, null);

		$tMap->addColumn('TIMEZONE_ID', 'TimezoneId', 'VARCHAR', false, 50);

		$tMap->addColumn('MODIFICATION_DATE', 'ModificationDate', 'DATE', false, null);

	} // doBuild()

} // GeonameCityMapBuilder
