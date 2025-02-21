<?php
namespace App\Service\Entity;
use App\Dto\Entity\UserDto;
use App\Model\Response\Entity\User\UserDetail;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Exception\NotFound\UserNotFoundException;
use App\Service\FileSystemService;
use App\Mapper\Entity\UserMapper;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class UserService
{
  public function __construct(
    private readonly UserRepository $userRepository,
    private readonly UserPasswordHasherInterface $passwordHasher,
    private FileSystemService $fileSystemService,
    private readonly UserMapper $userMapper
  ) {
  }

  public function login(int $id): User
  {
    $user = $this->userRepository->find($id);
    $user->setLastLogin(new \DateTime());
    $this->userRepository->store($user);
    return $user;
  }


  public function register(UserDto $userDto): void
  {

    $user = new User();
    $user
      ->setUsername($userDto->username)
      ->setRoles(['ROLE_USER'])
      ->setPassword($this->passwordHasher
        ->hashPassword($user, $userDto->password));

    if (null !== $userDto->email) {
      $user->setEmail($userDto->email);
    }
    if (null !== $userDto->about) {
      $user->setAbout($userDto->about);
    }
    if (null !== $userDto->age) {
      $user->setAge($userDto->age);
    }
    if (null !== $userDto->displayName) {
      $user->setDisplayName($userDto->displayName);
    }

    $this->userRepository->store($user);
  }

  public function uploadAvatar(int $id, $file): User
  {
    $user = $this->find($id);
    $dirname = $this->specifyUserAvatarsPath($user->getId());
    $currentFile = $this->fileSystemService->searchFiles($dirname, 'avatar' )[0] ?? null;
    if (null !== $currentFile) {
      $this->fileSystemService->removeFile($currentFile);
    }
    $this->fileSystemService->upload($file, $dirname, 'avatar');
    $fullPath = $this->fileSystemService->searchFiles($dirname, 'avatar')[0] ?? '';
    $shortPath = $this->fileSystemService->getShortPath($fullPath);
    if (file_exists($fullPath)) {
      $user->setAvatar($shortPath);
      $this->userRepository->store($user);
    }

    return $this->findForm($user->getId());
  }

  public function uploadCover(int $id, $file): User
  {
    $user = $this->find($id);
    $dirname = $this->specifyCoversPath($user->getId());
    $currentFile = $this->fileSystemService->searchFiles($dirname, 'cover' )[0] ?? null;
    if (null !== $currentFile) {
      $this->fileSystemService->removeFile($currentFile);
    }
    $this->fileSystemService->upload($file, $dirname, 'cover');
    $fullPath = $this->fileSystemService->searchFiles($dirname, 'cover')[0] ?? '';
    $shortPath = $this->fileSystemService->getShortPath($fullPath);
    if (file_exists($fullPath)) {
      $user->setCover($shortPath);
      $this->userRepository->store($user);
    }

    return $this->findForm($user->getId());
  }

  public function get(int $id): User
  {
    return $this->findForm($id);
  }

  public function edit(User $user,  UserDto $dto): UserDetail{
    $user
    ->setAbout($dto->about)
    ->setAge($dto->age)
    ->setEmail($dto->email)
    ->setDisplayName($dto->displayName);
    return $this->userMapper->mapToDetail($user, new UserDetail());
  }


  private function find(int $id): User
  {
    $user = $this->userRepository->find($id);
    if (null === $user) {
      throw new UserNotFoundException();
    }
    return $user;
  }

  public function findForm(int $id): User
  {
    $user = $this->userRepository->find($id);

    return $user;
  }


  private function specifyUserAvatarsPath(int $id): string
  {
    $subDirByIdPath = $this->createUploadsDir($id);

    $photosDirPath = $subDirByIdPath . DIRECTORY_SEPARATOR;
    $this->fileSystemService->createDir($photosDirPath);

    return $photosDirPath;
  }

  private function specifyCoversPath(int $id): string
  {
    $subDirByIdPath = $this->createUploadsDir($id);

    $photosDirPath = $subDirByIdPath . DIRECTORY_SEPARATOR;
    $this->fileSystemService->createDir($photosDirPath);

    return $photosDirPath;
  }

  private function createUploadsDir(int $id): string
  {
    $userMainUploadsDir = $this->fileSystemService->getUploadsDirname('user_avatars');

    $stringId = strval($id);
    $subDirByIdPath = $userMainUploadsDir . DIRECTORY_SEPARATOR . $stringId;

    $this->fileSystemService->createDir($subDirByIdPath);

    return $subDirByIdPath;
  }


}