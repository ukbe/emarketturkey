<?php

/**
 * Base class that represents a row from the 'EMT_RESUME_SKILL' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:19
 *
 * @package    lib.model.om
 */
abstract class BaseResumeSkill extends BaseObject  implements Persistent {


  const PEER = 'ResumeSkillPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ResumeSkillPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the resume_id field.
	 * @var        int
	 */
	protected $resume_id;

	/**
	 * The value for the skill_item_id field.
	 * @var        int
	 */
	protected $skill_item_id;

	/**
	 * The value for the proficiency_id field.
	 * @var        int
	 */
	protected $proficiency_id;

	/**
	 * @var        Resume
	 */
	protected $aResume;

	/**
	 * @var        SkillInventoryItem
	 */
	protected $aSkillInventoryItem;

	/**
	 * @var        Proficiency
	 */
	protected $aProficiency;

	/**
	 * @var        array SkillVerification[] Collection to store aggregation of SkillVerification objects.
	 */
	protected $collSkillVerifications;

	/**
	 * @var        Criteria The criteria used to select the current contents of collSkillVerifications.
	 */
	private $lastSkillVerificationCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Initializes internal state of BaseResumeSkill object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [resume_id] column value.
	 * 
	 * @return     int
	 */
	public function getResumeId()
	{
		return $this->resume_id;
	}

	/**
	 * Get the [skill_item_id] column value.
	 * 
	 * @return     int
	 */
	public function getSkillItemId()
	{
		return $this->skill_item_id;
	}

	/**
	 * Get the [proficiency_id] column value.
	 * 
	 * @return     int
	 */
	public function getProficiencyId()
	{
		return $this->proficiency_id;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     ResumeSkill The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ResumeSkillPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [resume_id] column.
	 * 
	 * @param      int $v new value
	 * @return     ResumeSkill The current object (for fluent API support)
	 */
	public function setResumeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->resume_id !== $v) {
			$this->resume_id = $v;
			$this->modifiedColumns[] = ResumeSkillPeer::RESUME_ID;
		}

		if ($this->aResume !== null && $this->aResume->getId() !== $v) {
			$this->aResume = null;
		}

		return $this;
	} // setResumeId()

	/**
	 * Set the value of [skill_item_id] column.
	 * 
	 * @param      int $v new value
	 * @return     ResumeSkill The current object (for fluent API support)
	 */
	public function setSkillItemId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->skill_item_id !== $v) {
			$this->skill_item_id = $v;
			$this->modifiedColumns[] = ResumeSkillPeer::SKILL_ITEM_ID;
		}

		if ($this->aSkillInventoryItem !== null && $this->aSkillInventoryItem->getId() !== $v) {
			$this->aSkillInventoryItem = null;
		}

		return $this;
	} // setSkillItemId()

	/**
	 * Set the value of [proficiency_id] column.
	 * 
	 * @param      int $v new value
	 * @return     ResumeSkill The current object (for fluent API support)
	 */
	public function setProficiencyId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->proficiency_id !== $v) {
			$this->proficiency_id = $v;
			$this->modifiedColumns[] = ResumeSkillPeer::PROFICIENCY_ID;
		}

		if ($this->aProficiency !== null && $this->aProficiency->getId() !== $v) {
			$this->aProficiency = null;
		}

		return $this;
	} // setProficiencyId()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			// First, ensure that we don't have any columns that have been modified which aren't default columns.
			if (array_diff($this->modifiedColumns, array())) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->resume_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->skill_item_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->proficiency_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 4; // 4 = ResumeSkillPeer::NUM_COLUMNS - ResumeSkillPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating ResumeSkill object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aResume !== null && $this->resume_id !== $this->aResume->getId()) {
			$this->aResume = null;
		}
		if ($this->aSkillInventoryItem !== null && $this->skill_item_id !== $this->aSkillInventoryItem->getId()) {
			$this->aSkillInventoryItem = null;
		}
		if ($this->aProficiency !== null && $this->proficiency_id !== $this->aProficiency->getId()) {
			$this->aProficiency = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ResumeSkillPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = ResumeSkillPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aResume = null;
			$this->aSkillInventoryItem = null;
			$this->aProficiency = null;
			$this->collSkillVerifications = null;
			$this->lastSkillVerificationCriteria = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseResumeSkill:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ResumeSkillPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			ResumeSkillPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseResumeSkill:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseResumeSkill:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ResumeSkillPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseResumeSkill:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			ResumeSkillPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aResume !== null) {
				if ($this->aResume->isModified() || $this->aResume->isNew()) {
					$affectedRows += $this->aResume->save($con);
				}
				$this->setResume($this->aResume);
			}

			if ($this->aSkillInventoryItem !== null) {
				if ($this->aSkillInventoryItem->isModified() || ($this->aSkillInventoryItem->getCulture() && $this->aSkillInventoryItem->getCurrentSkillInventoryItemI18n()->isModified()) || $this->aSkillInventoryItem->isNew()) {
					$affectedRows += $this->aSkillInventoryItem->save($con);
				}
				$this->setSkillInventoryItem($this->aSkillInventoryItem);
			}

			if ($this->aProficiency !== null) {
				if ($this->aProficiency->isModified() || ($this->aProficiency->getCulture() && $this->aProficiency->getCurrentProficiencyI18n()->isModified()) || $this->aProficiency->isNew()) {
					$affectedRows += $this->aProficiency->save($con);
				}
				$this->setProficiency($this->aProficiency);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = ResumeSkillPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ResumeSkillPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ResumeSkillPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collSkillVerifications !== null) {
				foreach ($this->collSkillVerifications as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aResume !== null) {
				if (!$this->aResume->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aResume->getValidationFailures());
				}
			}

			if ($this->aSkillInventoryItem !== null) {
				if (!$this->aSkillInventoryItem->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aSkillInventoryItem->getValidationFailures());
				}
			}

			if ($this->aProficiency !== null) {
				if (!$this->aProficiency->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aProficiency->getValidationFailures());
				}
			}


			if (($retval = ResumeSkillPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collSkillVerifications !== null) {
					foreach ($this->collSkillVerifications as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ResumeSkillPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getResumeId();
				break;
			case 2:
				return $this->getSkillItemId();
				break;
			case 3:
				return $this->getProficiencyId();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = ResumeSkillPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getResumeId(),
			$keys[2] => $this->getSkillItemId(),
			$keys[3] => $this->getProficiencyId(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ResumeSkillPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setResumeId($value);
				break;
			case 2:
				$this->setSkillItemId($value);
				break;
			case 3:
				$this->setProficiencyId($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ResumeSkillPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setResumeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSkillItemId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProficiencyId($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ResumeSkillPeer::DATABASE_NAME);

		if ($this->isColumnModified(ResumeSkillPeer::ID)) $criteria->add(ResumeSkillPeer::ID, $this->id);
		if ($this->isColumnModified(ResumeSkillPeer::RESUME_ID)) $criteria->add(ResumeSkillPeer::RESUME_ID, $this->resume_id);
		if ($this->isColumnModified(ResumeSkillPeer::SKILL_ITEM_ID)) $criteria->add(ResumeSkillPeer::SKILL_ITEM_ID, $this->skill_item_id);
		if ($this->isColumnModified(ResumeSkillPeer::PROFICIENCY_ID)) $criteria->add(ResumeSkillPeer::PROFICIENCY_ID, $this->proficiency_id);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ResumeSkillPeer::DATABASE_NAME);

		$criteria->add(ResumeSkillPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of ResumeSkill (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setResumeId($this->resume_id);

		$copyObj->setSkillItemId($this->skill_item_id);

		$copyObj->setProficiencyId($this->proficiency_id);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getSkillVerifications() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addSkillVerification($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     ResumeSkill Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     ResumeSkillPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ResumeSkillPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Resume object.
	 *
	 * @param      Resume $v
	 * @return     ResumeSkill The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setResume(Resume $v = null)
	{
		if ($v === null) {
			$this->setResumeId(NULL);
		} else {
			$this->setResumeId($v->getId());
		}

		$this->aResume = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Resume object, it will not be re-added.
		if ($v !== null) {
			$v->addResumeSkill($this);
		}

		return $this;
	}


	/**
	 * Get the associated Resume object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Resume The associated Resume object.
	 * @throws     PropelException
	 */
	public function getResume(PropelPDO $con = null)
	{
		if ($this->aResume === null && ($this->resume_id !== null)) {
			$c = new Criteria(ResumePeer::DATABASE_NAME);
			$c->add(ResumePeer::ID, $this->resume_id);
			$this->aResume = ResumePeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aResume->addResumeSkills($this);
			 */
		}
		return $this->aResume;
	}

	/**
	 * Declares an association between this object and a SkillInventoryItem object.
	 *
	 * @param      SkillInventoryItem $v
	 * @return     ResumeSkill The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setSkillInventoryItem(SkillInventoryItem $v = null)
	{
		if ($v === null) {
			$this->setSkillItemId(NULL);
		} else {
			$this->setSkillItemId($v->getId());
		}

		$this->aSkillInventoryItem = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the SkillInventoryItem object, it will not be re-added.
		if ($v !== null) {
			$v->addResumeSkill($this);
		}

		return $this;
	}


	/**
	 * Get the associated SkillInventoryItem object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     SkillInventoryItem The associated SkillInventoryItem object.
	 * @throws     PropelException
	 */
	public function getSkillInventoryItem(PropelPDO $con = null)
	{
		if ($this->aSkillInventoryItem === null && ($this->skill_item_id !== null)) {
			$c = new Criteria(SkillInventoryItemPeer::DATABASE_NAME);
			$c->add(SkillInventoryItemPeer::ID, $this->skill_item_id);
			$this->aSkillInventoryItem = SkillInventoryItemPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aSkillInventoryItem->addResumeSkills($this);
			 */
		}
		return $this->aSkillInventoryItem;
	}

	/**
	 * Declares an association between this object and a Proficiency object.
	 *
	 * @param      Proficiency $v
	 * @return     ResumeSkill The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setProficiency(Proficiency $v = null)
	{
		if ($v === null) {
			$this->setProficiencyId(NULL);
		} else {
			$this->setProficiencyId($v->getId());
		}

		$this->aProficiency = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Proficiency object, it will not be re-added.
		if ($v !== null) {
			$v->addResumeSkill($this);
		}

		return $this;
	}


	/**
	 * Get the associated Proficiency object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Proficiency The associated Proficiency object.
	 * @throws     PropelException
	 */
	public function getProficiency(PropelPDO $con = null)
	{
		if ($this->aProficiency === null && ($this->proficiency_id !== null)) {
			$c = new Criteria(ProficiencyPeer::DATABASE_NAME);
			$c->add(ProficiencyPeer::ID, $this->proficiency_id);
			$this->aProficiency = ProficiencyPeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aProficiency->addResumeSkills($this);
			 */
		}
		return $this->aProficiency;
	}

	/**
	 * Clears out the collSkillVerifications collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addSkillVerifications()
	 */
	public function clearSkillVerifications()
	{
		$this->collSkillVerifications = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collSkillVerifications collection (array).
	 *
	 * By default this just sets the collSkillVerifications collection to an empty array (like clearcollSkillVerifications());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initSkillVerifications()
	{
		$this->collSkillVerifications = array();
	}

	/**
	 * Gets an array of SkillVerification objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this ResumeSkill has previously been saved, it will retrieve
	 * related SkillVerifications from storage. If this ResumeSkill is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array SkillVerification[]
	 * @throws     PropelException
	 */
	public function getSkillVerifications($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ResumeSkillPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSkillVerifications === null) {
			if ($this->isNew()) {
			   $this->collSkillVerifications = array();
			} else {

				$criteria->add(SkillVerificationPeer::RESUME_SKILL_ID, $this->id);

				SkillVerificationPeer::addSelectColumns($criteria);
				$this->collSkillVerifications = SkillVerificationPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(SkillVerificationPeer::RESUME_SKILL_ID, $this->id);

				SkillVerificationPeer::addSelectColumns($criteria);
				if (!isset($this->lastSkillVerificationCriteria) || !$this->lastSkillVerificationCriteria->equals($criteria)) {
					$this->collSkillVerifications = SkillVerificationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSkillVerificationCriteria = $criteria;
		return $this->collSkillVerifications;
	}

	/**
	 * Returns the number of related SkillVerification objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related SkillVerification objects.
	 * @throws     PropelException
	 */
	public function countSkillVerifications(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ResumeSkillPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collSkillVerifications === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(SkillVerificationPeer::RESUME_SKILL_ID, $this->id);

				$count = SkillVerificationPeer::doCount($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(SkillVerificationPeer::RESUME_SKILL_ID, $this->id);

				if (!isset($this->lastSkillVerificationCriteria) || !$this->lastSkillVerificationCriteria->equals($criteria)) {
					$count = SkillVerificationPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collSkillVerifications);
				}
			} else {
				$count = count($this->collSkillVerifications);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a SkillVerification object to this object
	 * through the SkillVerification foreign key attribute.
	 *
	 * @param      SkillVerification $l SkillVerification
	 * @return     void
	 * @throws     PropelException
	 */
	public function addSkillVerification(SkillVerification $l)
	{
		if ($this->collSkillVerifications === null) {
			$this->initSkillVerifications();
		}
		if (!in_array($l, $this->collSkillVerifications, true)) { // only add it if the **same** object is not already associated
			array_push($this->collSkillVerifications, $l);
			$l->setResumeSkill($this);
		}
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collSkillVerifications) {
				foreach ((array) $this->collSkillVerifications as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collSkillVerifications = null;
			$this->aResume = null;
			$this->aSkillInventoryItem = null;
			$this->aProficiency = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseResumeSkill:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseResumeSkill::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseResumeSkill
