<?php

/**
 * Base class that represents a row from the 'EMT_RATING' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * 03/07/12 22:24:30
 *
 * @package    lib.model.om
 */
abstract class BaseRating extends BaseObject  implements Persistent {


  const PEER = 'RatingPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        RatingPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the item_id field.
	 * @var        int
	 */
	protected $item_id;

	/**
	 * The value for the item_type_id field.
	 * @var        int
	 */
	protected $item_type_id;

	/**
	 * The value for the client_ip field.
	 * @var        string
	 */
	protected $client_ip;

	/**
	 * The value for the session_id field.
	 * @var        string
	 */
	protected $session_id;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * The value for the visitor_id field.
	 * @var        int
	 */
	protected $visitor_id;

	/**
	 * The value for the visitor_type_id field.
	 * @var        int
	 */
	protected $visitor_type_id;

	/**
	 * @var        PrivacyNodeType
	 */
	protected $aPrivacyNodeType;

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
	 * Initializes internal state of BaseRating object.
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
	 * Get the [item_id] column value.
	 * 
	 * @return     int
	 */
	public function getItemId()
	{
		return $this->item_id;
	}

	/**
	 * Get the [item_type_id] column value.
	 * 
	 * @return     int
	 */
	public function getItemTypeId()
	{
		return $this->item_type_id;
	}

	/**
	 * Get the [client_ip] column value.
	 * 
	 * @return     string
	 */
	public function getClientIp()
	{
		return $this->client_ip;
	}

	/**
	 * Get the [session_id] column value.
	 * 
	 * @return     string
	 */
	public function getSessionId()
	{
		return $this->session_id;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-M-D H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}



		try {
			$dt = new DateTime($this->created_at);
		} catch (Exception $x) {
			throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [visitor_id] column value.
	 * 
	 * @return     int
	 */
	public function getVisitorId()
	{
		return $this->visitor_id;
	}

	/**
	 * Get the [visitor_type_id] column value.
	 * 
	 * @return     int
	 */
	public function getVisitorTypeId()
	{
		return $this->visitor_type_id;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rating The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = RatingPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [item_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rating The current object (for fluent API support)
	 */
	public function setItemId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->item_id !== $v) {
			$this->item_id = $v;
			$this->modifiedColumns[] = RatingPeer::ITEM_ID;
		}

		return $this;
	} // setItemId()

	/**
	 * Set the value of [item_type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rating The current object (for fluent API support)
	 */
	public function setItemTypeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->item_type_id !== $v) {
			$this->item_type_id = $v;
			$this->modifiedColumns[] = RatingPeer::ITEM_TYPE_ID;
		}

		return $this;
	} // setItemTypeId()

	/**
	 * Set the value of [client_ip] column.
	 * 
	 * @param      string $v new value
	 * @return     Rating The current object (for fluent API support)
	 */
	public function setClientIp($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->client_ip !== $v) {
			$this->client_ip = $v;
			$this->modifiedColumns[] = RatingPeer::CLIENT_IP;
		}

		return $this;
	} // setClientIp()

	/**
	 * Set the value of [session_id] column.
	 * 
	 * @param      string $v new value
	 * @return     Rating The current object (for fluent API support)
	 */
	public function setSessionId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->session_id !== $v) {
			$this->session_id = $v;
			$this->modifiedColumns[] = RatingPeer::SESSION_ID;
		}

		return $this;
	} // setSessionId()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Rating The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = RatingPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Set the value of [visitor_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rating The current object (for fluent API support)
	 */
	public function setVisitorId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->visitor_id !== $v) {
			$this->visitor_id = $v;
			$this->modifiedColumns[] = RatingPeer::VISITOR_ID;
		}

		return $this;
	} // setVisitorId()

	/**
	 * Set the value of [visitor_type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Rating The current object (for fluent API support)
	 */
	public function setVisitorTypeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->visitor_type_id !== $v) {
			$this->visitor_type_id = $v;
			$this->modifiedColumns[] = RatingPeer::VISITOR_TYPE_ID;
		}

		if ($this->aPrivacyNodeType !== null && $this->aPrivacyNodeType->getId() !== $v) {
			$this->aPrivacyNodeType = null;
		}

		return $this;
	} // setVisitorTypeId()

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
			$this->item_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->item_type_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->client_ip = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->session_id = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->created_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->visitor_id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->visitor_type_id = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 8; // 8 = RatingPeer::NUM_COLUMNS - RatingPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Rating object", $e);
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

		if ($this->aPrivacyNodeType !== null && $this->visitor_type_id !== $this->aPrivacyNodeType->getId()) {
			$this->aPrivacyNodeType = null;
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
			$con = Propel::getConnection(RatingPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = RatingPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPrivacyNodeType = null;
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

    foreach (sfMixer::getCallables('BaseRating:delete:pre') as $callable)
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
			$con = Propel::getConnection(RatingPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			RatingPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseRating:delete:post') as $callable)
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

    foreach (sfMixer::getCallables('BaseRating:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(RatingPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RatingPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseRating:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			RatingPeer::addInstanceToPool($this);
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

			if ($this->aPrivacyNodeType !== null) {
				if ($this->aPrivacyNodeType->isModified() || ($this->aPrivacyNodeType->getCulture() && $this->aPrivacyNodeType->getCurrentPrivacyNodeTypeI18n()->isModified()) || $this->aPrivacyNodeType->isNew()) {
					$affectedRows += $this->aPrivacyNodeType->save($con);
				}
				$this->setPrivacyNodeType($this->aPrivacyNodeType);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = RatingPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = RatingPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += RatingPeer::doUpdate($this, $con);
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

			if ($this->aPrivacyNodeType !== null) {
				if (!$this->aPrivacyNodeType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPrivacyNodeType->getValidationFailures());
				}
			}


			if (($retval = RatingPeer::doValidate($this, $columns)) !== true) {
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
		$pos = RatingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getItemId();
				break;
			case 2:
				return $this->getItemTypeId();
				break;
			case 3:
				return $this->getClientIp();
				break;
			case 4:
				return $this->getSessionId();
				break;
			case 5:
				return $this->getCreatedAt();
				break;
			case 6:
				return $this->getVisitorId();
				break;
			case 7:
				return $this->getVisitorTypeId();
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
		$keys = RatingPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getItemId(),
			$keys[2] => $this->getItemTypeId(),
			$keys[3] => $this->getClientIp(),
			$keys[4] => $this->getSessionId(),
			$keys[5] => $this->getCreatedAt(),
			$keys[6] => $this->getVisitorId(),
			$keys[7] => $this->getVisitorTypeId(),
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
		$pos = RatingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setItemId($value);
				break;
			case 2:
				$this->setItemTypeId($value);
				break;
			case 3:
				$this->setClientIp($value);
				break;
			case 4:
				$this->setSessionId($value);
				break;
			case 5:
				$this->setCreatedAt($value);
				break;
			case 6:
				$this->setVisitorId($value);
				break;
			case 7:
				$this->setVisitorTypeId($value);
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
		$keys = RatingPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setItemId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setItemTypeId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setClientIp($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSessionId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setVisitorId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setVisitorTypeId($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(RatingPeer::DATABASE_NAME);

		if ($this->isColumnModified(RatingPeer::ID)) $criteria->add(RatingPeer::ID, $this->id);
		if ($this->isColumnModified(RatingPeer::ITEM_ID)) $criteria->add(RatingPeer::ITEM_ID, $this->item_id);
		if ($this->isColumnModified(RatingPeer::ITEM_TYPE_ID)) $criteria->add(RatingPeer::ITEM_TYPE_ID, $this->item_type_id);
		if ($this->isColumnModified(RatingPeer::CLIENT_IP)) $criteria->add(RatingPeer::CLIENT_IP, $this->client_ip);
		if ($this->isColumnModified(RatingPeer::SESSION_ID)) $criteria->add(RatingPeer::SESSION_ID, $this->session_id);
		if ($this->isColumnModified(RatingPeer::CREATED_AT)) $criteria->add(RatingPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(RatingPeer::VISITOR_ID)) $criteria->add(RatingPeer::VISITOR_ID, $this->visitor_id);
		if ($this->isColumnModified(RatingPeer::VISITOR_TYPE_ID)) $criteria->add(RatingPeer::VISITOR_TYPE_ID, $this->visitor_type_id);

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
		$criteria = new Criteria(RatingPeer::DATABASE_NAME);

		$criteria->add(RatingPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Rating (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setItemId($this->item_id);

		$copyObj->setItemTypeId($this->item_type_id);

		$copyObj->setClientIp($this->client_ip);

		$copyObj->setSessionId($this->session_id);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setVisitorId($this->visitor_id);

		$copyObj->setVisitorTypeId($this->visitor_type_id);


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
	 * @return     Rating Clone of current object.
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
	 * @return     RatingPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new RatingPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PrivacyNodeType object.
	 *
	 * @param      PrivacyNodeType $v
	 * @return     Rating The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPrivacyNodeType(PrivacyNodeType $v = null)
	{
		if ($v === null) {
			$this->setVisitorTypeId(NULL);
		} else {
			$this->setVisitorTypeId($v->getId());
		}

		$this->aPrivacyNodeType = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PrivacyNodeType object, it will not be re-added.
		if ($v !== null) {
			$v->addRating($this);
		}

		return $this;
	}


	/**
	 * Get the associated PrivacyNodeType object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PrivacyNodeType The associated PrivacyNodeType object.
	 * @throws     PropelException
	 */
	public function getPrivacyNodeType(PropelPDO $con = null)
	{
		if ($this->aPrivacyNodeType === null && ($this->visitor_type_id !== null)) {
			$c = new Criteria(PrivacyNodeTypePeer::DATABASE_NAME);
			$c->add(PrivacyNodeTypePeer::ID, $this->visitor_type_id);
			$this->aPrivacyNodeType = PrivacyNodeTypePeer::doSelectOne($c, $con);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPrivacyNodeType->addRatings($this);
			 */
		}
		return $this->aPrivacyNodeType;
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

			$this->aPrivacyNodeType = null;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseRating:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseRating::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} // BaseRating
