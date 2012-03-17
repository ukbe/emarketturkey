<?php


/**
 * This class adds structure of 'EMT_PRODUCT_ATTR_OPTION' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/07/12 22:24:29
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ProductAttrOptionMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ProductAttrOptionMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ProductAttrOptionPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ProductAttrOptionPeer::TABLE_NAME);
		$tMap->setPhpName('ProductAttrOption');
		$tMap->setClassname('ProductAttrOption');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_PRODUCT_ATTR_OPTION_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 16);

		$tMap->addForeignKey('ATTRIBUTE_ID', 'AttributeId', 'INTEGER', 'EMT_PRODUCT_ATTR_DEF', 'ID', true, 16);

		$tMap->addColumn('SEQUENCE_NO', 'SequenceNo', 'INTEGER', false, 3);

	} // doBuild()

} // ProductAttrOptionMapBuilder
