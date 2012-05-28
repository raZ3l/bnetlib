Upgrade
=======

1.1 (2012-05-28)
------------------

**Connection:**
* All Connection specific classes/interfaces are now located under the `bnetlib\Connection` namespace.
* The Class `Connection`has been ranamed to `ZendFramework`. You can now choose between the Zend Framework and even a `Stub` adapter for testing and development.
* The setter for the configuration is now called `setOption()` instead of `setConfig()`.

**Resources:**
* The `ResourceInterface` now extends the `ServiceLocatorAwareInterface` and the `ConsumeInterface` now extends the `ResourceInterface`.

**Exceptions:**
* The `UnexpectedResponseException` will now only be thrown, if the returned status code does not meet the expectations. A new exception called `UnknownErrorException` will be thrown, if the library was unable to identify the error reason.

**Games:**
* The Method `setResource()` is now longer available, you've to use the `ServiceLocator` instead.