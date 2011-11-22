 <table width="100%" border="0">
    <tr>
        <td>
        
            <script type="text/javascript">
                $(function(){
                    $("#starify").children().not(":input").hide();
                            
                    // Create stars from :radio boxes
                    $("#starify").stars({
                        cancelShow: false
                    });
                });
            </script>
            <?php
            $qvote = mysql_query("SELECT * FROM t_produk WHERE id_produk = $_GET[idb]");
            $dvote = mysql_fetch_array($qvote);
            $rate = (int)ceil($dvote['rating_produk']);
            ?>
            <form class="uniForm" action="" method="post">
                    <div class="multiField" id="starify">
                        <input type="radio" name="vote" id="vote1" value="1" <?php if($rate==1) echo "checked=checked"; ?> />
                        <input type="radio" name="vote" id="vote2" value="2" <?php if($rate==2) echo "checked=checked"; ?> />
                        <input type="radio" name="vote" id="vote3" value="3" <?php if($rate==3) echo "checked=checked"; ?> />
                        <input type="radio" name="vote" id="vote4" value="4" <?php if($rate==4) echo "checked=checked"; ?> />
                        <input type="radio" name="vote" id="vote5" value="5" <?php if($rate==5) echo "checked=checked"; ?> />
                    </div>
                    <div class="buttonHolder">
                        <input type="hidden" name="idb" value="<?php echo $idb; ?>" />&nbsp;
                        <button name="submitvote" class="button" style="margin-top:0px;">
                        <span class="label1">Vote</span>
                        </button>
                    </div>
                </form>
        </td>
    </tr>
 </table>
