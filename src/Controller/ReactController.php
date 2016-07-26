<?php
namespace Drupal\react_app\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Component\Utility\Html;
use Drupal\user\UserAuth;
use Drupal\user\UserInterface;
use Drupal\user\UserStorageInterface;
use Drupal\user\Entity\User;

class ReactController extends ControllerBase {
    /**
   * The user storage.
   *
   * @var \Drupal\user\UserStorageInterface
   */
  protected $userStorage;

  private $email = NULL;
  private $password = NULL;
  private $username = NULL;
  private $response = NULL;
  /**
   * Drupal\user\UserAuth definition.
   *
   * @var \Drupal\user\UserAuth
   */
  protected $userAuth;

  /**
   * {@inheritdoc}
   */
  public function __construct(UserAuth $user_auth) {
      $this->userAuth = $user_auth;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('user.auth')
    );
  }

  public function postValue() {
    $this->username = Html::escape($_POST['user']);
    $this->password = Html::escape($_POST['pass']);
    $this->email = Html::escape($_POST['email']);
    return $this->registerUser();
  }

  public function registerUser() {
    $user = \Drupal\user\Entity\User::create();
    $user->setEmail($this->email);
    $user->setPassword($this->password);
    $user->setUsername($this->username);
    $user->enforceIsNew();
    if ($user->save()) {
       return new JsonResponse(['success']);
    } else {
       return new JsonResponse(['error']);
    }

  }

   public function loginUser() {
    $uid = $this->userAuth->authenticate(Html::escape($_POST['user']),Html::escape($_POST['pass']));
    $acc = User::load($uid);
    \Drupal::currentUser()->setAccount($acc);
    \Drupal::logger('user')->notice('Session opened for %name.', array('%name' => $acc->getUsername()));
    user_login_finalize($acc);
    return new JsonResponse(['response' => 'success','userId' => $uid]);
  }

}

