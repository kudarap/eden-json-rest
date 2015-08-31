<?php //-->

namespace Api\Page;

use Exception;
use Modules\Auth;
use Modules\Helper;
use Modules\Rest;
use Resources\File as F;

class File extends \Page 
{
    /* Constants
    --------------------------------------------*/
    /* Public Properties
    --------------------------------------------*/
    /* Protected Properties
    --------------------------------------------*/

    /* Public Methods
    --------------------------------------------*/
    public function getVariables()
    {   
        return Rest::resource(new F(), true);
    }
    
    /* Protected Methods
    --------------------------------------------*/
    /* Private Methods
    --------------------------------------------*/
}
