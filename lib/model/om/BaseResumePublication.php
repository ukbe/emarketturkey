<?php

/**
 * Base class that represents a row from the 'EMT_RESUME_PUBLICATION' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 05/10/12 16:10:21
 *
 * @package    lib.model.om
 */
abstract class BaseResumePublication extends BaseObject  implements Persistent {


  const PEER = 'ResumePublicationPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        ResumePublicationPeer
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
	 * The value for the subject field.
	 * @var        string
	 */
	protected $subject;

	/**
	 * The value for the publisher field.
	 * @var        string
	 */
	protected $publisher;

	/**
	 * The value for the edition field.
	 * @var        string
	 */
	protected $edition;

	/**
	 * The value for the co_authors field.
	 * @var        string
	 */
	protected $co_authors;

	/**
	 * The value for the isbn field.
	 * @var        string
	 */
	protected $isbn;

	/**
	 * The value for the binding field.
	 * @var        string
	 */
	protected $binding;

	/**
	 * @var        Resume
	 */
	protected $aResume;

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
	 * Initializes internal state of BaseResumePublication object.
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
	 * Get the [subject] column value.
	 * 
	 * @return     string
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * Get the [publisher] column value.
	 * 
	 * @return     string
	 */
	public function getPublisher()
	{
		return $this->publisher;
	}

	/**
	 * Get the [edition] column value.
	 * 
	 * @return     string
	 */
	public function getEdition()
	{
		return $this->edition;
	}

	/**
	 * Get the [co_authors] column value.
	 * 
	 * @return     string
	 */
	public function getCoAuthors()
	{
		return $this->co_authors;
	}

	/**
	 * Get the [isbn] column value.
	 * 
	 * @return     string
	 */
	public function getIsbn()
	{
		return $this->isbn;
	}

	/**
	 * Get the [binding] column value.
	 * 
	 * @return     string
	 */
	public function getBinding()
	{
		return $this->binding;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     ResumePublication The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ResumePublicationPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [resume_id] column.
	 * 
	 * @param      int $v new value
	 * @return     ResumePublication The current object (for fluent API support)
	 */
	public function setResumeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->resume_id !== $v) {
			$this->resume_id = $v;
			$this->modifiedColumns[] = ResumePublicationPeer::RESUME_ID;
		}

		if ($this->aResume !== null && $this->aResume->getId() !== $v) {
			$this->aResume = null;
		}

		return $this;
	} // setResumeId()

	/**
	 * Set the value of [subject] column.
	 * 
	 * @param      string $v new value
	 * @return     ResumePublication The current object (for fluent API support)
	 */
	public function setSubject($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->subject !== $v) {
			$this->subject = $v;
			$this->modifiedColumns[] = ResumePublicationPeer::SUBJECT;
		}

		return $this;
	} // setSubject()

	/**
	 * Set the value of [publisher] column.
	 * 
	 * @param      string $v new value
	 * @return     ResumePublication The current object (for fluent API support)
	 */
	public function setPublisher($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->publisher !== $v) {
			$this->publisher = $v;
			$this->modifiedColumns[] = ResumePublicationPeer::PUBLISHER;
		}

		return $this;
	} // setPublisher()

	/**
	 * Set the value of [edition] column.
	 * 
	 * @param      string $v new value
	 * @return     ResumePublication The current object (for fluent API support)
	 */
	public function setEdition($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->edition !== $v) {
			$this->edition = $v;
			$this->modifiedColumns[] = ResumePublicationPeer::EDITION;
		}

		return $this;
	} // setEdition()

	/**
	 * Set the value of [co_authors] column.
	 * 
	 * @param      string $v new value
	 * @return     ResumePublication The current object (for fluent API support)
	 */
	public function setCoAuthors($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->co_authors !== $v) {
			$this->co_authors = $v;
			$this->modifiedColumns[] = ResumePublicationPeer::CO_AUTHORS;
		}

		return $this;
	} // setCoAuthors()

	/**
	 * Set the value of [isbn] column.
	 * 
	 * @param      string $v new value
	 * @return     ResumePublication The current object (for fluent API support)
	 */
	public function setIsbn($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->isbn !== $v) {
			$this->isbn = $v;
			$this->modifiedColumns[] = ResumePublicationPeer::ISBN;
		}

		return $this;
	} // setIsbn()

	/**
	 * Set the value of [binding] column.
	 * 
	 * @param      string $v new value
	 * @return     ResumePublication The current object (for fluent API support)
	 */
	public function setBinding($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->binding !== $v) {
			$this->binding = $v;
			$this->modifiedColumns[] = ResumePublicationPeer::BINDING;
		}

		return $this;
	} // setBinding()

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
			$this->subject = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->publisher = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->edition = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->co_authors = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->isbn = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->binding = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 8; // 8 = ResumePublicationPeer::NUM_COLUMNS - ResumePublicationPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating ResumePublication object", $e);
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
			$con = Propel::getConnection(ResumePublicationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = ResumePublicationPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aResume = null;
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

    foreach (sfMixer::getCallables('BaseResumePublication:delete:pre') as $callable)
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
			$con = Propel::getConnection(ResumePublicationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			ResumePublicationPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseResumePublication:delete:post') as $callable)
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

    foreach (sfMixer::getCallables('BaseResumePublication:save:pre') as $callable)
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
			$con = Propel::getConnection(ResumePublicationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseResumePublication:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			ResumePublicationPeer::addInstanceToPool($this);
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

			if ($this->isNew() ) {
				$this->modifiedColumns[] = ResumePublicationPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ResumePublicationPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += ResumePublicationPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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


			if (($retval = ResumePublicationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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
		$pos = ResumePublicationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSubject();
				break;
			case 3:
				return $this->getPublisher();
				break;
			case 4:
				return $this->getEdition();
				break;
			case 5:
				return $this->getCoAuthors();
				break;
			case 6:
				return $this->getIsbn();
				break;
			case 7:
				return $this->getBinding();
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
		$keys = ResumePublicationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getResumeId(),
			$keys[2] => $this->getSubject(),
			$keys[3] => $this->getPublisher(),
			$keys[4] => $this->getEdition(),
			$keys[5] => $this->getCoAuthors(),
			$keys[6] => $this->getIsbn(),
			$keys[7] => $this->getBinding(),
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
		$pos = ResumePublicationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSubject($value);
				break;
			case 3:
				$this->setPublisher($value);
				break;
			case 4:
				$this->setEdition($value);
				break;
			case 5:
				$this->setCoAuthors($value);
				break;
			case 6:
				$this->setIsbn($value);
				break;
			case 7:
				$this->setBinding($value);
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
		$keys = ResumePublicationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setResumeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSubject($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPublisher($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setEdition($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCoAuthors($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsbn($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setBinding($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(ResumePublicationPeer::DATABASE_NAME);

		if ($this->isColumnModified(ResumePublicationPeer::ID)) $criteria->add(ResumePublicationPeer::ID, $this->id);
		if ($this->isColumnModified(ResumePublicationPeer::RESUME_ID)) $criteria->add(ResumePublicationPeer::RESUME_ID, $this->resume_id);
		if ($this->isColumnModified(ResumePublicationPeer::SUBJECT)) $criteria->add(ResumePublicationPeer::SUBJECT, $this->subject);
		if ($this->isColumnModified(ResumePublicationPeer::PUBLISHER)) $criteria->add(ResumePublicationPeer::PUBLISHER, $this->publisher);
		if ($this->isColumnModified(ResumePublicationPeer::EDITION)) $criteria->add(ResumePublicationPeer::EDITION, $this->edition);
		if ($this->isColumnModified(ResumePublicationPeer::CO_AUTHORS)) $criteria->add(ResumePublicationPeer::CO_AUTHORS, $this->co_authors);
		if ($this->isColumnModified(ResumePublicationPeer::ISBN)) $criteria->add(ResumePublicationPeer::ISBN, $this->isbn);
		if ($this->isColumnModified(ResumePublicationPeer::BINDING)) $criteria->add(ResumePublicationPeer::BINDING, $this->binding);

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
		$criteria = new Criteria(ResumePublicationPeer::DATABASE_NAME);

		$criteria->add(ResumePublicationPeer::ID, $this->id);
		$criteria->add(ResumePublicationPeer::RESUME_ID, $this->resume_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getResumeId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setResumeId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of ResumePublication (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setResumeId($this->resume_id);

		$copyObj->setSubject($this->subject);

		$copyObj->setPublisher($this->publisher);

		$copyObj->setEdition($this->edition);

		$copyObj->setCoAuthors($this->co_authors);

		$copyObj->setIsbn($this->isbn);

		$copyObj->setBinding($this->binding);


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
	 * @return     ResumePublication Clone of current object.
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
	 * @return     ResumePublicationPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ResumePublicationPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Resume object.
	 *
	 * @param      Resume $v
	 * @return     ResumePublication The current object (for fluent API support)
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
			$v->addResumePublication($this);
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
			   $this->aResume->addResumePublications($this);
			 */
		}
		return $this->aResume;
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
		} // if ($deep)

			$this->aResume = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseResumePublication:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseResumePublication::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseResumePublication
