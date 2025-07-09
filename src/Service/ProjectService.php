<?php
namespace App\Service;
use App\Repository\ProjectRepository;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
class ProjectService
{
    public function __construct(private ProjectRepository $projectRepository,  private EntityManagerInterface $entityManager,
        private SluggerInterface $slugger,
        private string $uploadDir // injecté via services.yaml
        ) {   $this->projectRepository = $projectRepository;    $this->uploadDir = $uploadDir;
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;}

    public function getAllProjects(): array
    {
        return $this->projectRepository->findAll();
    }

    


    public function getFilteredProjects(?string $title, ?string $status, ?string $filename): array
    {
        return $this->projectRepository->findByFilters($title, $status, $filename);
    }

    public function createProject(Project $project, ?UploadedFile $imageFile): void
    {
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            $imageFile->move($this->uploadDir, $newFilename);
            $project->setImage($newFilename);
        }

        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }
   
}


