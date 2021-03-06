<?php
/**
 * Copyright (c) 2014 Matthias Kleine
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@mkleine.de so we can send you a copy immediately.
 *
 * @category    MKleine
 * @package     MKleine_LanguageRoutes
 * @copyright   Copyright (c) 2014 Matthias Kleine (http://mkleine.de)
 * @license     http://opensource.org/licenses/MIT MIT
 */

/**
 * Class MKleine_LanguageRoutes_Model_Core_Url
 *
 * @method setNoTranslate
 * @method getNoTranslate
 */
class MKleine_LanguageRoutes_Model_Core_Url extends Mage_Core_Model_Url
{
    /**
     * @return MKleine_LanguageRoutes_Model_Translation
     */
    protected function getTranslationModel()
    {
        return Mage::getSingleton('mk_languageroutes/translation');
    }

    protected function translationEnabled()
    {
        return ($this->getNoTranslate() !== true);
    }

    public function setRouteParams(array $data, $unsetOldParams = true)
    {
        if (isset($data['_notranslate'])) {
            $this->setNoTranslate($data['_notranslate']);
            unset($data['_notranslate']);
        }

        parent::setRouteParams($data, $unsetOldParams);
    }

    /**
     * Translates the route part before delivered to frontend
     *
     * @return false|mixed|string
     */
    public function getRouteFrontName()
    {
        if (!$this->translationEnabled()) {
            return parent::getRouteFrontName();
        }

        return $this->getTranslationModel()->translateRouteToFront(parent::getRouteFrontName());
    }

    /**
     * Translates the controller part before delivered to frontend
     *
     * @return false|mixed|null|string
     */
    public function getControllerName()
    {
        if (!$this->translationEnabled()) {
            return parent::getControllerName();
        }

        return $this->getTranslationModel()->translateControllerToFront(parent::getControllerName());
    }

    /**
     * Translates the action part before delivered to frontend
     *
     * @return false|mixed|null|string
     */
    public function getActionName()
    {
        if (!$this->translationEnabled()) {
            return parent::getActionName();
        }

        return $this->getTranslationModel()->translateActionToFront(parent::getActionName());
    }
}