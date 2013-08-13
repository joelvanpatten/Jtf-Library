<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_ArrayCacheTests
 *
 * @copyright   Copyright (C) 2011 Joseph Fallon <joseph.t.fallon@gmail.com>
 *              All rights reserved.
 *
 * @license     REDISTRIBUTION AND USE IN SOURCE AND BINARY FORMS, WITH OR
 *              WITHOUT MODIFICATION, IS NOT PERMITTED WITHOUT EXPRESS
 *              WRITTEN APPROVAL OF THE AUTHOR.
 *
 *              THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY
 *              EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 *              THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
 *              PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE
 *              AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 *              SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 *              NOT LIMITED TO, PROCUREMENT OF  SUBSTITUTE GOODS OR SERVICES;
 *              LOSS OF USE, DATA, OR PROFITS;  OR BUSINESS INTERRUPTION)
 *              HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 *              CONTRACT, STRICT LIABILITY, OR TORT INCLUDING NEGLIGENCE OR
 *              OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 *              SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
class Jtf_ArrayCacheTests extends KissUnitTest
{
    public function test_value_stored_can_be_retrieved()
    {
        $cache = new Jtf_ArrayCache();
        
        $id    = 'key1';
        $value = 'value1';
        
        $cache->save($value, $id);
        $this->assertTrue($cache->test($id));
        
        $out = $cache->load($id);
        $this->assertEqual($out, $value);
    }
    
    public function test_clean_with_no_params_removes_all()
    {
        $cache = new Jtf_ArrayCache();
        
        $id    = 'key1';
        $value = 'value1';
        
        $cache->save($value, $id);
        $cache->clean();
        $this->assertFalse($cache->test($id));
    }
    
    public function test_clean_matching_tag()
    {
        $cache = new Jtf_ArrayCache();
        
        $id    = 'key1';
        $value = 'value1';
        
        $tags1 = array('tag1');
        $tags2 = array('tag1', 'tag2');
        
        $cache->save($value, $id, $tags1);
        $this->assertTrue($cache->test($id));
        
        $cache->clean(Jtf_ArrayCache::CLEANING_MODE_MATCHING_TAG, $tags2);
        $this->assertTrue($cache->test($id), 'Value was removed.');
        
        $cache->clean(Jtf_ArrayCache::CLEANING_MODE_MATCHING_TAG, $tags1);
        $this->assertFalse($cache->test($id), 'Value still exists.');
    }
    
    //public function
}