DCMS Routing Bundle
===================

[![Build Status](https://secure.travis-ci.org/dantleech/DCMSRoutingBundle.png)](http://travis-ci.org/dantleech/DCMSRoutingBundle)

This bundle provides dynamic, extensible, database routing.

 * Entities can be assigned a URL from a centralized routing table
 * Requests are handled by a dedicated **Endpoint class** which sets up the request, i.e. which controller to use, which parameters should be in the request, etc.
 * Routes are handled transparently by Doctrine - routes are updated and removed according to the Entity.

This is currently a work in progress.

Stuff that works and is tested:

 * URL Matching via. Router
 * Doctrine integration

Stuff not tested:

 * Validator

Stuff not currently implemented:

 * URL Generation

