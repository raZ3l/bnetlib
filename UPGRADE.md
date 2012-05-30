Upgrade
=======

1.1 (2012-05-28)
------------------

**Connection:**
* All connection specific classes/interfaces are now located under the `Connection` namespace.
* The class `Connection` has been ranamed to `ZendFramework`. You can now choose between the `ZendFramework` and `Stub` adapter for testing and development.
* The setter for the options is now called `setOptions()` instead of `setConfig()`.

**Resources:**
* Renamed `ResourceInterface` to `EntityInterface`.
* Moved `EntityInterface` and `ConsumeInterface` to `Resource\Entity` and `ConsumeInterface` to `Resource\Config` namespace.
* Improved folder structure for resources. Configuration and Entity classes are now located under their own namespace.
* The `EntityInterface` now extends the `ServiceLocatorAwareInterface` and the `ConsumeInterface` now extends the `EntityInterface`.

**Exceptions:**
* The `UnexpectedResponseException` will now only be thrown, if the returned status code does not meet the expectations. A new exception called `UnknownErrorException` will be thrown, if the library was unable to identify the error reason.

**Games:**
* The method `setResource()` is now longer available, you've to use the `ServiceLocator` instead.