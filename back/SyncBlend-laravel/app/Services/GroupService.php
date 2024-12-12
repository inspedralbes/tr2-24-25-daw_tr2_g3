namespace App\Services;

use App\Models\Group;

class GroupService
{
/**
* Crear un nuevo grupo.
*
* @param array $data
* @return Group
*/
public function create(array $data): Group
{
return Group::create($data);
}
}
