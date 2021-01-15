The idea is that there is the `ContextProvider` interface which declares a single method:

```php
interface ContextProvider
{
    /**
     * @return array<string, string>
     */
    public function getContext(): array;
}
```

At the DBAL level, we don't know what the context means for a given application or framework,
we don't know how the application transitions from one context to another, we can only enforce its
representation that has to be provided to the DBAL.

For a given application, this interface can be implemented with the addition of any methods
that help describe the context. For instance:
```php
final class ExampleContextProvider implements ContextProvider
{
    /** @var array<string,string> */
    private $context = [];

    /**
     * @param array<string,string> $context
     */
    public function enterContext(array $context): void
    {
        $this->context = $context;
    }

    public function leaveContext(): void
    {
        $this->context = [];
    }

    /**
     * {@inheritDoc}
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
```

At the DBAL, we need to build the `Commenter` middleware, pass the context provider to it
and add to the connection configuration. From that moment on, each query executed by the
DBAL will be amended by the parameters taken from the context provided by the provider:

```php
use Doctrine\DBAL\DriverManager;
use Doctrine\SQLCommenter\Example\ExampleContextProvider;
use Doctrine\SQLCommenter\Middleware;

// The exact API and implementation of the ContextProvider will vary per-project/framework
$contextProvider = new ExampleContextProvider();

$connection = DriverManager::getConnection([]);
$connection->getConfiguration()->setMiddlewares([
    new Middleware($contextProvider)
]);

$connection->executeQuery('SELECT 1');
$contextProvider->enterContext(['foo' => 'bar']);
$connection->executeQuery('SELECT 2');
$contextProvider->leaveContext();
$connection->executeQuery('SELECT 3');
```
Note, it's just a PoC of adding it to the DBAL. The exact format of the comment is to be clarified and implemented.
