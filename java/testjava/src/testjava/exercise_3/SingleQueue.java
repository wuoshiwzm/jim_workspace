package testjava.exercise_3;

public class SingleQueue<AnyType> {
	private Node<AnyType> tail;
	private Node<AnyType> head;
	
	SingleQueue(){
		tail = null;
		head = null;
	}
	
	public void push(AnyType data){
		Node<AnyType> p = new Node(data,null);
		
		if(tail != null){
			tail.behind = p;
			tail = tail.behind;
		}
		else{
			tail = p;
			head = tail =p;
		}
	}
	
	public void pop(){
		AnyType temp = head.data;

		if(head.behind == null){
			head = tail = null;
		}else{
			head = head.behind;
		}
		return temp;
	}
	
	
	
	
	
	private class Node<AnyType>{
		Node(){
			this(null,null);
		}
		Node(AnyType x){
			this(x,null);
		}
		Node(AnyType x,Node b){
			data =x;
			behind = b;
		}
				
		AnyType data;

		Node behind;
	}

}
