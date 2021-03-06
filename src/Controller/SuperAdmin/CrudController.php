<?php

namespace App\Controller\SuperAdmin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Service\StringTransformer\CaseString;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Provider\ListDatabaseProvider;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * @author Corinne Poullette
 * @version 1.01
 * @example your routes : /superadmin/your-entity or /superadmin/yourEntity  ...
 * @Route("/dashboard")
 */
class CrudController extends AbstractController
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var CaseString
     */
    private $caseString;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var ListDatabaseProvider
     */
    private $listProvider;

    /**
     * @var
     */
    private $crudAuthorizedClasses;

    /**
     * CrudController constructor.
     * @param RegistryInterface $registry
     * @param CaseString $caseString
     * @param TranslatorInterface $translator
     * @param ListDatabaseProvider $listProvider
     * @param $crudAuthorizedClasses
     */
    public function __construct(RegistryInterface $registry,
                                CaseString $caseString,
                                TranslatorInterface $translator,
                                ListDatabaseProvider $listProvider,
                                $crudAuthorizedClasses)
    {
        $this->entityNamespace = 'App\\Entity\\';
        $this->formNamespace = 'App\\Form\\';
        $this->registry = $registry;
        $this->caseString = $caseString;
        $this->translator = $translator;
        $reflectionExtractor = new ReflectionExtractor();
        $this->propertyInfo = new PropertyInfoExtractor(
            [$reflectionExtractor]
        );
        $this->listProvider = $listProvider;
        $this->crudAuthorizedClasses = $crudAuthorizedClasses;
    }

    /**
     * @return Response
     *
     * @Route("/", name="crud_dashboard", methods={"GET"})
     */
    public function dashboard()
    {
        return $this->render('superadmin/superadmin_dashboard.html.twig');
    }

    /**
     * @param string $class
     * @param array|null $params
     * @return Response
     *
     * @Route("/{class}", name="crud_index", methods={"GET"})
     */
    public function index(string $class, ?array $params): Response
    {
        $this->checkIfCrudClassAuthorized($class);
        $className = $this->getClassName($class);
        $this->checkIfCrudClassExist($className);

        $entities = $this->listProvider->getListForClass($className);

        $templateDir = $this->evalTemplateDir($class);
        $template = $this->get('twig')->getLoader()->exists('superadmin/' . $templateDir . '/index.html.twig')
            ? 'superadmin/' . $templateDir . '/index.html.twig'
            : 'superadmin/crud/index.html.twig';


        return $this->render($template, [
            'entities' => $entities,
            'params' => $params,
            'class' => $class,
            'properties' => $this->getClassProperties($className),
            'property_keys' => $this->propertyNameToDotKey($className)
        ]);
    }

    /**
     * @param Request $request
     * @param $class
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route("/{class}/new", name="crud_new", methods={"GET","POST"})
     */
    public function new(Request $request, $class): Response
    {
        $this->checkIfCrudClassAuthorized($class);
        $className = $this->getClassName($class);
        $this->checkIfCrudClassExist($className);
        $this->checkIfCrudClassExist($this->formNamespace . ucfirst($class) . 'Type');

        $entity = new $className;
        $form = $this->createForm($this->formNamespace . ucfirst($class) . 'Type', $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->registry->getEntityManager()->persist($entity);
                $this->registry->getEntityManager()->flush();

                $this->addFlash('success', $this->translator->trans('new.success', [], 'crud'));
                return $this->redirectToRoute('crud_index', [
                    'class' => $class,
                ]);
            }
            $this->addFlash('error', $this->translator->trans('new.error', [], 'crud'));
        }

        $templateDir = $this->evalTemplateDir($class);
        $template = $this->get('twig')->getLoader()->exists('superadmin/' . $templateDir . '/new.html.twig')
            ? 'superadmin/' . $templateDir . '/new.html.twig'
            : 'superadmin/crud/new.html.twig';

        return $this->render($template, [
            'entity' => $entity,
            'form' => $form->createView(),
            'class' => $class
        ]);
    }

    /**
     * @param $class
     * @param $id
     * @return Response
     *
     * @Route("/{class}/{id}", name="crud_show", methods={"GET"})
     */
    public function show($class, $id): Response
    {
        $this->checkIfCrudClassAuthorized($class);
        $className = $this->getClassName($class);
        $this->checkIfCrudClassExist($className);

        $repository = $this->registry->getRepository($className);

        $entity = $repository->find($id);

        $templateDir = $this->evalTemplateDir($class);
        $template = $this->get('twig')->getLoader()->exists('superadmin/' . $templateDir . '/show.html.twig')
            ? 'superadmin/' . $templateDir . '/show.html.twig'
            : 'superadmin/crud/show.html.twig';

        return $this->render($template, [
            'entity' => $entity,
            'class' => $class,
            'tab_properties_keys' => $this->buildTabOfPropertiesAndKeys($className),
        ]);
    }

    /**
     * @param Request $request
     * @param $class
     * @param $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route("/{class}/{id}/edit", name="crud_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $class, $id): Response
    {
        $this->checkIfCrudClassAuthorized($class);
        $className = $this->getClassName($class);
        $this->checkIfCrudClassExist($className);
        $this->checkIfCrudClassExist($this->formNamespace . ucfirst($class) . 'Type');

        $entity = $this->getEntity($className, $id);
        $form = $this->createForm($this->formNamespace . ucfirst($class) . 'Type', $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->registry->getEntityManager()->flush();
                $this->addFlash('success', $this->translator->trans('edit.success', [], 'crud'));
                return $this->redirectToRoute('crud_index', [
                    'class' => $class,
                ]);
            }
            $this->addFlash('error', $this->translator->trans('edit.error', [], 'crud'));
        }

        $templateDir = $this->evalTemplateDir($class);
        $template = $this->get('twig')->getLoader()->exists('superadmin/' . $templateDir . '/edit.html.twig')
            ? 'superadmin/' . $templateDir . '/edit.html.twig'
            : 'superadmin/crud/edit.html.twig';

        return $this->render($template, [
            'entity' => $entity,
            'class' => $class,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param $class
     * @param $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route("{class}/{id}", name="crud_delete", methods={"DELETE"})
     */
    public function delete(Request $request, $class, $id): Response
    {
        $this->checkIfCrudClassAuthorized($class);
        $className = $this->getClassName($class);
        $this->checkIfCrudClassExist($className);

        $entity = $this->getEntity($className, $id);
        if ($this->isCsrfTokenValid('delete' . $entity->getId(), $request->request->get('_token'))) {
            $this->registry->getEntityManager()->remove($entity);
            $this->registry->getEntityManager()->flush();
            $this->addFlash('success', $this->translator->trans('remove.success', [], 'crud'));
        } else {
            $this->addFlash('error', $this->translator->trans('remove.error', [], 'crud'));
        }

        return $this->redirectToRoute('crud_index', [
            'class' => $class
        ]);
    }

    /**
     * @param $class
     * @return string
     */
    private function getClassName($class): string
    {
        $class = $this->evalClassInUrl($class);
        return $this->entityNamespace . ucfirst($class);
    }

    /**
     * @param $className
     */
    private function checkIfCrudClassExist($className): void
    {
        if (!class_exists($className)) {
            throw new FileException($this->translator->trans('class.not_found', [], 'crud'));
        }
        return;
    }

    /**
     * @param $class
     */
    private function checkIfCrudClassAuthorized($class)
    {
        if (!in_array($class, $this->crudAuthorizedClasses)) {
            throw new UnauthorizedHttpException($this->translator->trans('class.unauthorized', [], 'crud'));
        }
    }

    /**
     * @param $className
     * @param $id
     * @return null|object
     */
    private function getEntity($className, $id)
    {
        $repository = $this->registry->getRepository($className);
        return $repository->find($id);
    }

    /**
     * @param $class
     * @return string
     */
    private function evalClassInUrl($class): string
    {
        if (strpos($class, '-')) {
            $class = $this->caseString::kebab($class)->camel();
        }
        return $class;
    }

    /**
     * @param $className
     * @return array
     */
    private function getClassProperties($className): array
    {
        return $this->propertyInfo->getProperties($className);
    }

    /**
     * @param $class
     * @return string
     */
    private function evalTemplateDir($class): string
    {
        if (strpos($class, '-')) {
            $class = $this->caseString::kebab($class)->snake();
        } else {
            $class = $this->caseString::camel($class)->snake();
        }
        return $class;
    }

    /**
     * @param $className
     * @return array
     */
    private function propertyNameToDotKey($className): array
    {
        $properties = $this->getClassProperties($className);
        foreach ($properties as $property) {
            $propertiesAsKeys[] = $this->caseString::camel($property)->dot();
        }
        return $propertiesAsKeys;
    }

    /**
     * @param $className
     * @return array
     */
    private function buildTabOfPropertiesAndKeys($className)
    {
        $properties = $this->getClassProperties($className);
        foreach ($properties as $property) {
            $tabPropertiesAndKeys[] = [$property, $this->caseString::camel($property)->dot()];
        }
        return $tabPropertiesAndKeys;
    }
}
