<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 08/07/2019
 * Time: 17:59
 */

namespace App\Service;

use App\Form\AgentType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Translation\Translator;

/**
 * Class CrudService
 * @package App\Service
 *
 * The purpose of the service is to replace the cruds controllers and be able to perform the same methods
 */
class CrudService
{
    private $flashBag;
    private $router;
    private $formFactory;
    private $environment;
    private $request;
    private $registry;
    private $locale;

    public function __construct(FlashBagInterface $flashBag,
                                RouterInterface $router,
                                FormFactoryInterface $formFactory,
                                Environment $environment,
                                RequestStack $request,
                                RedirectController $redirectController,
                                RegistryInterface $registry, $locale)
    {
        $this->flashBag = $flashBag;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->environment = $environment;
        $this->request = $request;
        $this->redirectController = $redirectController;
        $this->registry = $registry;
        $this->entityNamespace = 'App\\Entity\\';
        $this->locale = $locale;
        $this->translator = new Translator($this->locale);
    }

    /**
     * @param string $class
     * @param string $template
     * @param $params
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function displayAllItems(string $class, string $template, ?array $params)
    {
        $className = $this->entityNamespace.$class;
        $repository = $this->registry->getRepository($className);

        $entities = $repository->findAll();
        $view = $this->environment->render($template, [
                'entities' => $entities,
                'params' => $params
            ]
        );

        return $view;
    }

    /**
     * @param $entity
     * @param $id
     * @param $template
     * @param $params
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function displayOneItem(string $class, int $id, $template)
    {
        $className = $this->entityNamespace.$class;
        $repository = $this->registry->getRepository($className);

        if (!$entity = $repository->findOneBy($id)) {
            throw new NotFoundHttpException($this->translator->trans('entity.notfound', [], 'crud'));
        }

        $view = $this->environment->render($template, [
                'entity' => $entity
            ]
        );

        return $view;
    }

    /**
     * @param $entity
     * @param $template
     * @param $params
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addNewEntity(string $class, $template)
    {
        $className = $this->entityNamespace.$class;
        $newEntity = new $className;
//        $form = $this->formFactory->create(AgentType::class, $newEntity);
        //todo no functionnal form
        $form = $this->formFactory->create($class.'Type::class', $newEntity);
        $view = $this->environment->render($template, [
            'form' => $form->createView()
        ]);

        return $view;
    }

    /**
     * @param $entity
     * @param $template
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function editEntity($entity, $template)
    {
        $className = get_class($entity);

        $form = $this->formFactory->create($className.'Type::class', $entity);
        $view = $this->environment->render($template, [
            'form' => $form->createView()
        ]);

        return $view;
    }

    /**
     * @param Form $form
     * @param $newEntity
     * @param $redirectRoute
     * @param $template
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function processForm(Form $form, $entity, $redirectRoute, $template, $mode)
    {
        $form->handleRequest($this->request);

        if($form->isSubmitted()) {
            if ($form->isValid()) {
                if ($mode === "create") {
                    $this->registry->getManager()->persist($entity);
                }
                $this->registry->getManager()->flush();
                $this->flashBag->add('success', $this->translator->trans('add.new.success', [], 'crud'));
                $this->redirectController->redirectAction($this->request->getCurrentRequest(), $redirectRoute);
            }
        }

        if ($this->request->getCurrentRequest()->isMethod("POST")) {
            $this->flashBag->add('error', $this->translator->trans('add.new.error', [], 'crud'));
        }

        $view = $this->environment->render($template, [
            'form' => $form->createView()
        ]);

        return $view;
    }

    public function removeItem($entity, $id, $redirectRoute)
    {
        $className = get_class($entity);

        $manager = $this->registry->getManager($className.'::class');
        $manager->remove($id);
        $manager->flush();

        $this->flashBag->add('info', $this->translator->trans('remove.success', [], 'crud'));

        return $this->redirectController->redirectAction($this->request->getCurrentRequest(), $redirectRoute);
    }
}