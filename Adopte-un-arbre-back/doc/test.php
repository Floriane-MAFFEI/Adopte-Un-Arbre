/**

    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(MovieRepository $movieRepository): JsonResponse
    {
        $allMovies = $movieRepository->findAll();

        return $this->json($allMovies, 200, [], ["groups" => ["movie_list", "genre_show"]]);
    }

     /**
     * @Route("/{id}", name="read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id, MovieRepository $movieRepository): JsonResponse
    {
        $movie = $movieRepository->find($id);

        if ($movie === null){return $this->json("message d'erreur",Response::HTTP_NOT_FOUND);}

        return $this->json($movie, 200, [], ["groups" => ["movie_read", "genre_show", "season_read"]]);
    }
 /**
     * @Route("/{id}", name="edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit(
        $id,
        Request $request,
        MovieRepository $movieRepository,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
        ): JsonResponse
    {
        $movie = $movieRepository->find($id);

        if ($movie === null){return $this->json("message d'erreur",Response::HTTP_NOT_FOUND);}

        $jsonContent = $request->getContent();

        $serializerInterface->deserialize(
            $jsonContent,
            Movie::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $movie]);
        // ici la fusion entre l'objet BDD et l'objet JSON a été faites
        // dd($movie);

        $errors = $validatorInterface->validate($movie);
        if (count($errors) > 0) {
            return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $movieRepository->add($movie, true);

        return $this->json($movie, 200, [], ["groups" => ["movie_read", "genre_show", "season_read"]]);
    }
/**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(
        MovieRepository $movieRepository,
        Request $request,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface): JsonResponse
    {
        $jsonContent = $request->getContent();
        // on reçoit aucun JSON
        if ($jsonContent === ""){return $this->json("Le contenu de la requete est invalide", Response::HTTP_BAD_REQUEST);}

        $movie = $serializerInterface->deserialize($jsonContent, Movie::class, 'json');

        $errors = $validatorInterface->validate($movie);
        if (count($errors) > 0) {return $this->json($errors,Response::HTTP_UNPROCESSABLE_ENTITY);}

        $movieRepository->add($movie, true);

        return $this->json($movie, 200, [], ["groups" => ["movie_read", "genre_show", "season_read"]]);
    }
 /**
     * @Route("/{id}", name="delete", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function delete(
        $id,
        MovieRepository $movieRepository
        ): JsonResponse
    {
        // 1. aller l'objet dans la BDD
        $movie = $movieRepository->find($id);
        // on a pas trouvé en BDD
        if ($movie === null){
            return $this->json(
                // 1. un message d'erreur
                "Aucune movie avec cet ID : " . $id,
                //2. code HTTP : 404 NOT_FOUND
                Response::HTTP_NOT_FOUND,
            );
        }
        // 2. utiliser le repository pour faire un remove
        $movieRepository->remove($movie, true);
        // 3. on renvoit une réponse JSON
        return $this->json(
            // 1. aucune donnée à fournir, peut être un message
            null,
            //2. code HTTP : 204 NO_CONTENT
            Response::HTTP_NO_CONTENT,
        );
    }

    * 
    */