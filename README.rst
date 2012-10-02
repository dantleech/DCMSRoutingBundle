DCMS Routing Bundle
===================

This bundle provides dynamic, extensible, database routing.

 * Entities can be assigned a URL from a centralized routing table
 * Requests are handled by a dedicated **Endpoint class** which sets up the request, i.e. which controller to use, which parameters should be in the request, etc.
 * Routes are handled transparently by Doctrine - routes are updated and removed according to the Entity.

This is currently a work in progress.
