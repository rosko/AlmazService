<?

// Model api example
/*
function resourceById($type, $id) {
    $responseBuilder = ResponseBuilderFactory::responseBuilder('json');
    
    if (!DatabaseManager::manager()->validateResourceType($type))
        return $responseBuilder->makeErrorResponse(INVALID_TYPE_ERROR);
    
    $record = DatabaseManager::manager()->getResourceById($type, $id);
    if (!$record)
        return $responseBuilder->makeErrorResponse(INVALID_ARG_ERROR);
    
    $responseBuilder->addRecord($record);
    
    return $responseBuilder->makeResponse();
}

function resources($type, $from, $to) {
    $responseBuilder = ResponseBuilderFactory::responseBuilder('json');
    
    if (!DatabaseManager::manager()->validateResourceType($type))
        return $responseBuilder->makeErrorResponse(INVALID_TYPE_ERROR);
    
    $count = DatabaseManager::manager()->getResourcesCount($type);
    if ($count <= $from)
        return $responseBuilder->makeErrorResponse(INVALID_ARG_ERROR);
    
    $resources = DatabaseManager::manager()->getResources($type, $from, $to);
    foreach ($resources as $oneResource) {
        $responseBuilder->addRecord($oneResource);
    }
    
    return $responseBuilder->makeResponse();
}
*/

?>
