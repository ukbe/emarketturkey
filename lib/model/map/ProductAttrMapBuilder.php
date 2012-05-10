<?php


/**
 * This class adds structure of 'EMT_PRODUCT_ATTR' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:29
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class ProductAttrMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ProductAttrMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ProductAttrPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ProductAttrPeer::TABLE_NAME);
		$tMap->setPhpName('ProductAttr');
		$tMap->setClassname('ProductAttr');

		$tMap->setUseIdGenerator(true);

		$tMap->setPrimaryKeyMethodInfo('EMT_PRODUCT_ATTR_SEQ');

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, 16);

		$tMap->addForeignKey('PRODUCT_ID', 'ProductId', 'INTEGER', 'EMT_PRODUCT', 'ID', true, 10);

		$tMap->addForeignKey('ATTR_OPTION_ID', 'AttrOptionId', 'INTEGER', 'EMT_PRODUCT_ATTR_OPTION', 'ID', true, 16);

	} // doBuild()

} // ProductAttrMapBuilder
