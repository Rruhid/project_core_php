<?php

if(isset($_POST['checkBoxArray'])){
	foreach($_POST['checkBoxArray'] as $postValueId ){
		$bulk_options=$_POST['bulk_options'];
		switch($bulk_options){
			case 'published':
			$query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id= {$postValueId}";
			$update_to_published_status= mysqli_query($connection,$query);
			confirmQuery($update_to_published_status);
			break;
			case 'draft':
			$query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id= {$postValueId}";
			$update_to_draft_status= mysqli_query($connection,$query);
		
			confirmquery($update_to_draft_status);
			break;
				case 'delete':
			$query = "DELETE FROM  posts  WHERE post_id= {$postValueId}";
			$update_to_delete_status= mysqli_query($connection,$query);
		
			confirmQuery($update_to_delete_status);
				break;
				
				
				case'clone':
				$query="SELECT * FROM posts WHERE post_id='{$postValueId}'";
				$select_post_query=mysqli_query($connection,$query);
				while($row=mysqli_fetch_array($select_post_query)){
					$post_title=escape($row['post_title']);
					$post_category_id=escape($row['post_category_id']);
					$post_date=escape($row['post_date']);
					$post_author=escape($row['post_author']);
					$post_status=escape($row['post_status']);
					$post_image=escape($row['post_image']);
					$post_tags=escape($row['post_tags']);
					$post_content=escape($row['post_content']);
				}
		
			$query="INSERT INTO posts (post_category_id,post_title,post_author,post_date,post_image,post_content,post_tags,post_status)";
			$query .="VALUES ({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
			$post_query=mysqli_query($connection,$query);
			if (!$post_query){
				die("alinmadi".mysqli_error($connection));
				
			}
			break;
			
			
		}
		
	}
	
	
}
?>



<form action="" method='post'>
			<table class="table table-bordered table-hover"> 
			<div id="bulkOptionsContainer" class="col-xs-4">
			<select class="form-control" name="bulk_options" id="">
			<option value="">select options</option>
			<option value="published">publish</option>
			<option value="draft">draft</option>
			<option value="delete">delete</option>
		 <option value="clone">Clone</option>
			
			</select>
			</div>
			<div class="col-xs-4">
			<input type="submit" name="submit" class="btn btn-success" value="Apply">
			<a class="btn btn-primary" href="posts.php?source=add_post">Add new</a>
			</div>

			<thead>
			<tr>
			<th><input id="selectAllBoxes" type="checkbox"></th>
			<th>id</th>
			<th>author</th>
			<th>title</th>
			<th>Category</th>
			<th>Status</th>
			<th>Image</th>
			<th>Tags</th>
			<th>Comments</th>
			<th>Date</th>
			<th>view</th>
           <th>edit</th>
			<th>delete</th>
			</tr>
			</thead>

			<tbody>

			
  <?php 
    
    $query = "SELECT * FROM posts  ORDER BY post_id DESC";
    $select_posts = mysqli_query($connection,$query);  

    while($row = mysqli_fetch_assoc($select_posts )) {
        $post_id            = $row['post_id'];
        $post_author        = $row['post_author'];
		//$post_user          = $row['post_user'];
        $post_title         = $row['post_title'];
        $post_category_id   = $row['post_category_id'];
        $post_status        = $row['post_status'];
        $post_image         = $row['post_image'];
        $post_tags          = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date          = $row['post_date'];
        
       
			echo "<tr>";
			?>
     <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
	 
			<?php
			echo "<td>$post_id</td>";
			echo "<td> $post_author</td>";
			echo "<td> $post_title</td>";
			
			$query="SELECT * FROM categories WHERE cat_id={$post_category_id}";
			$select_categories_id= mysqli_query($connection,$query);
			while($row= mysqli_fetch_assoc($select_categories_id)){
			$cat_id=$row['cat_id'];
			$cat_title=$row['cat_title'];
			echo "<td>{$cat_title}</td>";
			}
			
			echo "<td>$post_status</td>";
			echo "<td><img width='80' src='../images/$post_image' alt='images'></td>";
			echo "<td>$post_tags</td>";
			echo "<td>$post_comment_count</td>";
			echo  "<td>$post_date</td>";
	        echo  "<td><a href='../post.php?p_id={$post_id}'>view post</a></td>";echo  "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>edit</a></td>";
	echo  "<td><a onClick=\"javascript:return confirm('Eminsiz?'); \" href='posts.php?delete={$post_id}'>delete</a></td>";
			echo "</tr>";


			}


			?>


			</tbody>

			</table>
			 </form>

			<?php

			if(isset($_GET['delete'])){
			$the_post_id = $_GET['delete'];
			$query = "DELETE FROM posts WHERE post_id=$the_post_id";
			$delete_query = mysqli_query($connection, $query);
			header("Location:posts.php"); 

			}

			?>
 



				
				
				
			