<?php
/**
 * Auto generated from snet_idle.proto at 2015-05-19 22:05:05
 */

/**
 * snet_idle message
 */
class SnetIdle extends \ProtobufMessage
{
    /* Field index constants */
    const DATACONTAINER = 1;
    const DROIDGUARD = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::DATACONTAINER => array(
            'name' => 'datacontainer',
            'required' => true,
            'type' => 'DataContainer'
        ),
        self::DROIDGUARD => array(
            'name' => 'droidGuard',
            'required' => true,
            'type' => 7,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::DATACONTAINER] = null;
        $this->values[self::DROIDGUARD] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'datacontainer' property
     *
     * @param DataContainer $value Property value
     *
     * @return null
     */
    public function setDatacontainer(DataContainer $value)
    {
        return $this->set(self::DATACONTAINER, $value);
    }

    /**
     * Returns value of 'datacontainer' property
     *
     * @return DataContainer
     */
    public function getDatacontainer()
    {
        return $this->get(self::DATACONTAINER);
    }

    /**
     * Sets value of 'droidGuard' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setDroidGuard($value)
    {
        return $this->set(self::DROIDGUARD, $value);
    }

    /**
     * Returns value of 'droidGuard' property
     *
     * @return string
     */
    public function getDroidGuard()
    {
        return $this->get(self::DROIDGUARD);
    }
}

/**
 * dataContainer message
 */
class DataContainer extends \ProtobufMessage
{
    /* Field index constants */
    const NONCE = 1;
    const APKPACKAGENAME = 2;
    const APKCERTIFICATEDIGESTSHA256 = 3;
    const APKDIGESTSHA256 = 4;
    const GMSVERSION = 5;
    const SUEXEC = 6;
    const UNKNOWNDATA = 7;
    const TIMESTAMP = 8;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::NONCE => array(
            'name' => 'nonce',
            'required' => true,
            'type' => 7,
        ),
        self::APKPACKAGENAME => array(
            'name' => 'apkPackageName',
            'required' => true,
            'type' => 7,
        ),
        self::APKDIGESTSHA256 => array(
            'name' => 'apkDigestSha256',
            'required' => true,
            'type' => 7,
        ),
        self::APKCERTIFICATEDIGESTSHA256 => array(
            'name' => 'apkCertificateDigestSha256',
            'required' => true,
            'type' => 7,
        ),
        self::GMSVERSION => array(
            'name' => 'gmsVersion',
            'required' => true,
            'type' => 5,
        ),
        self::SUEXEC => array(
            'name' => 'suexec',
            'repeated' => true,
            'type' => 'SuExec'
        ),
        self::UNKNOWNDATA => array(
            'name' => 'unknowndata',
            'required' => false,
            'type' => 'UnknownData'
        ),
        self::TIMESTAMP => array(
            'name' => 'timestamp',
            'required' => true,
            'type' => 5,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::NONCE] = null;
        $this->values[self::APKPACKAGENAME] = null;
        $this->values[self::APKDIGESTSHA256] = null;
        $this->values[self::APKCERTIFICATEDIGESTSHA256] = null;
        $this->values[self::GMSVERSION] = null;
        $this->values[self::SUEXEC] = array();
        $this->values[self::UNKNOWNDATA] = null;
        $this->values[self::TIMESTAMP] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'nonce' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setNonce($value)
    {
        return $this->set(self::NONCE, $value);
    }

    /**
     * Returns value of 'nonce' property
     *
     * @return string
     */
    public function getNonce()
    {
        return $this->get(self::NONCE);
    }

    /**
     * Sets value of 'apkPackageName' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setApkPackageName($value)
    {
        return $this->set(self::APKPACKAGENAME, $value);
    }

    /**
     * Returns value of 'apkPackageName' property
     *
     * @return string
     */
    public function getApkPackageName()
    {
        return $this->get(self::APKPACKAGENAME);
    }

    /**
     * Sets value of 'apkDigestSha256' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setApkDigestSha256($value)
    {
        return $this->set(self::APKDIGESTSHA256, $value);
    }

    /**
     * Returns value of 'apkDigestSha256' property
     *
     * @return string
     */
    public function getApkDigestSha256()
    {
        return $this->get(self::APKDIGESTSHA256);
    }

    /**
     * Sets value of 'apkCertificateDigestSha256' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setApkCertificateDigestSha256($value)
    {
        return $this->set(self::APKCERTIFICATEDIGESTSHA256, $value);
    }

    /**
     * Returns value of 'apkCertificateDigestSha256' property
     *
     * @return string
     */
    public function getApkCertificateDigestSha256()
    {
        return $this->get(self::APKCERTIFICATEDIGESTSHA256);
    }

    /**
     * Sets value of 'gmsVersion' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setGmsVersion($value)
    {
        return $this->set(self::GMSVERSION, $value);
    }

    /**
     * Returns value of 'gmsVersion' property
     *
     * @return int
     */
    public function getGmsVersion()
    {
        return $this->get(self::GMSVERSION);
    }

    /**
     * Appends value to 'suexec' list
     *
     * @param SuExec $value Value to append
     *
     * @return null
     */
    public function appendSuexec(SuExec $value)
    {
        return $this->append(self::SUEXEC, $value);
    }

    /**
     * Clears 'suexec' list
     *
     * @return null
     */
    public function clearSuexec()
    {
        return $this->clear(self::SUEXEC);
    }

    /**
     * Returns 'suexec' list
     *
     * @return SuExec[]
     */
    public function getSuexec()
    {
        return $this->get(self::SUEXEC);
    }

    /**
     * Returns 'suexec' iterator
     *
     * @return ArrayIterator
     */
    public function getSuexecIterator()
    {
        return new \ArrayIterator($this->get(self::SUEXEC));
    }

    /**
     * Returns element from 'suexec' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return SuExec
     */
    public function getSuexecAt($offset)
    {
        return $this->get(self::SUEXEC, $offset);
    }

    /**
     * Returns count of 'suexec' list
     *
     * @return int
     */
    public function getSuexecCount()
    {
        return $this->count(self::SUEXEC);
    }

    /**
     * Sets value of 'unknowndata' property
     *
     * @param UnknownData $value Property value
     *
     * @return null
     */
    public function setUnknowndata(UnknownData $value)
    {
        return $this->set(self::UNKNOWNDATA, $value);
    }

    /**
     * Returns value of 'unknowndata' property
     *
     * @return UnknownData
     */
    public function getUnknowndata()
    {
        return $this->get(self::UNKNOWNDATA);
    }

    /**
     * Sets value of 'timestamp' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setTimestamp($value)
    {
        return $this->set(self::TIMESTAMP, $value);
    }

    /**
     * Returns value of 'timestamp' property
     *
     * @return int
     */
    public function getTimestamp()
    {
        return $this->get(self::TIMESTAMP);
    }
}

/**
 * suExec message
 */
class SuExec extends \ProtobufMessage
{
    /* Field index constants */
    const EXECPATH = 1;
    const EXECSIGNATURE = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::EXECPATH => array(
            'name' => 'execPath',
            'required' => true,
            'type' => 7,
        ),
        self::EXECSIGNATURE => array(
            'name' => 'execSignature',
            'required' => true,
            'type' => 7,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::EXECPATH] = null;
        $this->values[self::EXECSIGNATURE] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'execPath' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setExecPath($value)
    {
        return $this->set(self::EXECPATH, $value);
    }

    /**
     * Returns value of 'execPath' property
     *
     * @return string
     */
    public function getExecPath()
    {
        return $this->get(self::EXECPATH);
    }

    /**
     * Sets value of 'execSignature' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setExecSignature($value)
    {
        return $this->set(self::EXECSIGNATURE, $value);
    }

    /**
     * Returns value of 'execSignature' property
     *
     * @return string
     */
    public function getExecSignature()
    {
        return $this->get(self::EXECSIGNATURE);
    }
}

/**
 * unknownData message
 */
class UnknownData extends \ProtobufMessage
{
    /* Field index constants */
    const UNKNOWN1 = 1;
    const UNKNOWN2 = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::UNKNOWN1 => array(
            'name' => 'unknown1',
            'required' => true,
            'type' => 8,
        ),
        self::UNKNOWN2 => array(
            'name' => 'unknown2',
            'required' => true,
            'type' => 8,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::UNKNOWN1] = null;
        $this->values[self::UNKNOWN2] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'unknown1' property
     *
     * @param bool $value Property value
     *
     * @return null
     */
    public function setUnknown1($value)
    {
        return $this->set(self::UNKNOWN1, $value);
    }

    /**
     * Returns value of 'unknown1' property
     *
     * @return bool
     */
    public function getUnknown1()
    {
        return $this->get(self::UNKNOWN1);
    }

    /**
     * Sets value of 'unknown2' property
     *
     * @param bool $value Property value
     *
     * @return null
     */
    public function setUnknown2($value)
    {
        return $this->set(self::UNKNOWN2, $value);
    }

    /**
     * Returns value of 'unknown2' property
     *
     * @return bool
     */
    public function getUnknown2()
    {
        return $this->get(self::UNKNOWN2);
    }
}
