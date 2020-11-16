thead


<?php 

                                if($result){
                                    $i = 1;
                                    foreach($result as $value){
                                ?>
                                      <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo escape($value['title']); ?></td>
                                        <td><?php echo escape(substr($value['content'],0,100)); ?>...</td>
                                        <td style="width: 50px"><a href="edit.php?id=<?php echo $value['id']; ?>"><input type="submit" value="Edit" class="btn btn-primary text-center"></a></td>
                                        <td style="width: 50px"><a href="delete.php?id=<?php echo $value['id']; ?>"><input type="submit" value="Delete" class="btn btn-primary text-center" onclick="return confirm('Are you sure you want to delete this item')"></a></td>

                                    </tr>  

                                <?php
                                    $i++;
                                    }
                                }



                            ?>
