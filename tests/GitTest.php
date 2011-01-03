<?php
/*
 * This file is part of the PECL_Git package.
 * (c) Shuhei Tanuma
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
 /*
 Git repository management routines

 [x]git_repository_open
 []git_repository_open2(not support)
 []git_repository_lookup (そのうち)
 []git_repository_database (そのうち)
 [x]git_repository_index
 []git_repository_newobject(そのうち)
 []git_repository_free(内部的に実装)
 []git_repository_init(確認とれん)
 */
 
 class GitTest extends \PHPUnit_Framework_TestCase
 {
     protected function setUp()
     {
         // currentry nothing to do.
     }
     
     protected function tearDown()
     {
         // currentry nothing to do.
     }
     
     public function testGetTree()
     {
        $git = new Git("./.git");
        $tree= $git->getTree("c40b970eb68bd1c8980f1f97b57396f4c7ae107f");
        $this->assertInstanceof("GitTree",$tree);
        $this->assertEquals("c40b970eb68bd1c8980f1f97b57396f4c7ae107f",$tree->getId());
     }
     
     public function testRepositoryInit()
     {
         $repo = Git::init("/tmp/uhi",1);
         $this->assertInstanceof("Git",$repo);
     }

     public function testConstruct()
     {
         try{
             $git = new Git("./.git");
         }catch(\Exception $e){
             $this->fail();
         }
     }
     
     public function testGetIndex()
     {

//        $this->markTestIncomplete("testGetIndex not implemented yet");

         $git = new Git("./.git");
         $index = $git->getIndex();
         if($index instanceof GitIndex){
             return true;
         }else{
             return false;
         }
     }
     
     public function testHexToRaw()
     {
         $hex = "599955586da1c3ad514f3e65f1081d2012ec862d";
         $raw = git_hex_to_raw($hex);

         $this->assertEquals(
            "WZlVWG2hw61RTz5l8QgdIBLshi0=",
            base64_encode($raw),
            "Hex to raw conversion"
         );
     }
     
     public function testRawToHex()
     {
         $raw = base64_decode("WZlVWG2hw61RTz5l8QgdIBLshi0=");
         $hex = git_raw_to_hex($raw);
         
         $this->assertEquals(
             "599955586da1c3ad514f3e65f1081d2012ec862d",
             $hex,
             "Raw to hex conversion"
             );
     }
     
     /**
      * @dataProvider getStringToTypeSpecifications
      */
     public function testStringToType($expected, $str_type, $comment)
     {
         $this->assertEquals($expected, git_string_to_type($str_type), $comment);
     }
     
     public function getStringToTypeSpecifications()
     {
         $array = array();
         $array[] = array(Git::OBJ_COMMIT,"commit","commit type id");
         $array[] = array(Git::OBJ_BLOB,  "blob",  "blob type id");
         $array[] = array(Git::OBJ_TREE,  "tree",  "tree type id");
         $array[] = array(Git::OBJ_TAG,   "tag",   "tag type id");

         return $array;
     }
     
     /**
      * @dataProvider getTypeToStringSpecifications
      */
     public function testTypeToString($expected, $type, $comment)
     {
         $this->assertEquals($expected, git_type_to_string($type), $comment);
     }

     public function getTypeToStringSpecifications()
     {
         $array = array();
         $array[] = array("commit",Git::OBJ_COMMIT,"commit type string");
         $array[] = array("blob",  Git::OBJ_BLOB,  "blob type string");
         $array[] = array("tree",  Git::OBJ_TREE,  "tree type string");
         $array[] = array("tag",   Git::OBJ_TAG,   "tag type string");

         return $array;
     }

 }